<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicineSchedule;
use App\Models\ComplianceLog;
use App\Services\ResendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules
     */
    public function index(Request $request)
    {
        $query = MedicineSchedule::with(['user', 'medicine', 'creator']);

        // Filter by patient
        if ($patientId = $request->input('patient_id')) {
            $query->where('user_id', $patientId);
        }

        // Filter by status
        if ($request->input('status') === 'active') {
            $query->active();
        } elseif ($request->input('status') === 'expired') {
            $query->where('end_date', '<', Carbon::today());
        }

        $schedules = $query->orderBy('created_at', 'desc')->paginate(15);

        $patients = User::where('role', 'patient')->where('is_active', true)->get();

        return view('admin.schedules.index', compact('schedules', 'patients'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create(Request $request)
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->orderBy('name')->get();
        
        $selectedPatient = null;
        if ($patientId = $request->input('patient_id')) {
            $selectedPatient = User::find($patientId);
        }

        return view('admin.schedules.create', compact('patients', 'medicines', 'selectedPatient'));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'medicine_id' => ['required', 'exists:medicines,id'],
            'dosage' => ['required', 'string', 'max:100'],
            'frequency_per_day' => ['required', 'integer', 'min:1', 'max:6'],
            'time_slots' => ['required', 'array', 'min:1'],
            'time_slots.*' => ['required', 'date_format:H:i'],
            'instruction' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'notes' => ['nullable', 'string'],
            'send_email_reminder' => ['nullable', 'boolean'],
        ]);

        $validated['created_by'] = Auth::id();
        $validated['send_email_reminder'] = $request->has('send_email_reminder');

        $schedule = MedicineSchedule::create($validated);

        // Generate compliance logs for the schedule period
        $this->generateComplianceLogs($schedule);

        // Send notification email to patient about new schedule
        if ($schedule->send_email_reminder) {
            $this->sendScheduleNotification($schedule, 'created');
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal obat berhasil dibuat! ' . ($schedule->send_email_reminder ? 'Email reminder akan dikirim otomatis.' : ''));
    }

    /**
     * Display the specified schedule
     */
    public function show(MedicineSchedule $schedule)
    {
        $schedule->load(['user', 'medicine', 'creator', 'complianceLogs']);

        $complianceLogs = $schedule->complianceLogs()
            ->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->paginate(20);

        return view('admin.schedules.show', compact('schedule', 'complianceLogs'));
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit(MedicineSchedule $schedule)
    {
        $patients = User::where('role', 'patient')->where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->orderBy('name')->get();

        return view('admin.schedules.edit', compact('schedule', 'patients', 'medicines'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, MedicineSchedule $schedule)
    {
        $oldSchedule = clone $schedule;

        $validated = $request->validate([
            'dosage' => ['required', 'string', 'max:100'],
            'frequency_per_day' => ['required', 'integer', 'min:1', 'max:6'],
            'time_slots' => ['required', 'array', 'min:1'],
            'time_slots.*' => ['required', 'date_format:H:i'],
            'instruction' => ['required', 'string', 'max:255'],
            'end_date' => ['required', 'date', 'after_or_equal:' . $schedule->start_date->format('Y-m-d')],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'send_email_reminder' => ['nullable', 'boolean'],
        ]);

        $validated['send_email_reminder'] = $request->has('send_email_reminder');
        $schedule->update($validated);

        // Send notification if schedule changed and email is enabled
        if ($schedule->send_email_reminder) {
            $hasChanged = $oldSchedule->time_slots != $schedule->time_slots ||
                         $oldSchedule->notes != $schedule->notes ||
                         $oldSchedule->dosage != $schedule->dosage ||
                         $oldSchedule->instruction != $schedule->instruction;

            if ($hasChanged) {
                $this->sendScheduleNotification($schedule, 'updated');
            }
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal obat berhasil diperbarui!');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(MedicineSchedule $schedule)
    {
        $schedule->update(['is_active' => false]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal obat berhasil dinonaktifkan.');
    }

    /**
     * Generate compliance logs for schedule
     */
    protected function generateComplianceLogs(MedicineSchedule $schedule)
    {
        $startDate = Carbon::parse($schedule->start_date);
        $endDate = Carbon::parse($schedule->end_date);

        while ($startDate->lte($endDate)) {
            foreach ($schedule->time_slots as $timeSlot) {
                ComplianceLog::create([
                    'schedule_id' => $schedule->id,
                    'user_id' => $schedule->user_id,
                    'scheduled_date' => $startDate->format('Y-m-d'),
                    'scheduled_time' => $timeSlot,
                    'status' => 'pending',
                ]);
            }
            $startDate->addDay();
        }
    }

    /**
     * Send schedule notification email to patient
     */
    protected function sendScheduleNotification(MedicineSchedule $schedule, string $action = 'created')
    {
        try {
            $schedule->load(['user', 'medicine']);
            $resendService = new ResendMailService();

            $subject = $action === 'created'
                ? '📋 Jadwal Obat Baru - ' . $schedule->medicine->name
                : '🔔 Perubahan Jadwal Obat - ' . $schedule->medicine->name;

            $html = view('emails.schedule-notification', [
                'user' => $schedule->user,
                'schedule' => $schedule,
                'action' => $action
            ])->render();

            $resendService->send([
                'to' => [$schedule->user->email],
                'subject' => $subject,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send schedule notification: ' . $e->getMessage());
        }
    }
}
