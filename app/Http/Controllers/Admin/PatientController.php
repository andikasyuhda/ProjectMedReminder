<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ComplianceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of patients
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'patient');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('medical_record_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $patients = $query->withCount(['medicineSchedules as active_schedules_count' => function ($q) {
            $q->active();
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created patient
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female'],
            'address' => ['nullable', 'string', 'max:500'],
            'blood_pressure_target' => ['nullable', 'string', 'max:10'],
        ]);

        $validated['medical_record_number'] = User::generateMedicalRecordNumber();
        $validated['role'] = 'patient';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Pasien berhasil ditambahkan!');
    }

    /**
     * Display the specified patient
     */
    public function show(User $patient)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        // Get compliance stats
        $weekStart = Carbon::now()->subDays(7);
        $logs = ComplianceLog::where('user_id', $patient->id)
            ->where('scheduled_date', '>=', $weekStart)
            ->with(['schedule.medicine'])
            ->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->get();

        $activeSchedules = $patient->medicineSchedules()
            ->with('medicine')
            ->active()
            ->get();

        return view('admin.patients.show', compact('patient', 'logs', 'activeSchedules'));
    }

    /**
     * Show the form for editing the specified patient
     */
    public function edit(User $patient)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient
     */
    public function update(Request $request, User $patient)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $patient->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female'],
            'address' => ['nullable', 'string', 'max:500'],
            'blood_pressure_target' => ['nullable', 'string', 'max:10'],
            'is_active' => ['boolean'],
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil diperbarui!');
    }

    /**
     * Remove the specified patient
     */
    public function destroy(User $patient)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        $patient->update(['is_active' => false]);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Pasien berhasil dinonaktifkan.');
    }
}
