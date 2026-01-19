<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicineSchedule;
use App\Models\ComplianceLog;
use App\Models\ScheduleReminder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $today = Carbon::today();

        // Stats
        $totalPatients = User::where('role', 'patient')->where('is_active', true)->count();
        $activeSchedules = MedicineSchedule::active()->count();
        
        // Patients needing attention (compliance < 80%)
        $patientsNeedingAttention = $this->getPatientsNeedingAttention();

        // Today's compliance overview
        $todayStats = $this->getTodayStats();

        // Email stats
        $emailStats = $this->getEmailStats();

        // Recent activity
        $recentLogs = ComplianceLog::with(['user', 'schedule.medicine'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'activeSchedules',
            'patientsNeedingAttention',
            'todayStats',
            'emailStats',
            'recentLogs'
        ));
    }

    /**
     * Get patients with compliance rate < 80%
     */
    protected function getPatientsNeedingAttention()
    {
        $weekStart = Carbon::now()->subDays(7);
        
        $patients = User::where('role', 'patient')
            ->where('is_active', true)
            ->withCount([
                'complianceLogs as completed_count' => function ($query) use ($weekStart) {
                    $query->where('status', 'completed')
                        ->where('scheduled_date', '>=', $weekStart);
                },
                'complianceLogs as total_count' => function ($query) use ($weekStart) {
                    $query->whereIn('status', ['completed', 'missed'])
                        ->where('scheduled_date', '>=', $weekStart);
                }
            ])
            ->get()
            ->filter(function ($patient) {
                if ($patient->total_count == 0) return false;
                $compliance = ($patient->completed_count / $patient->total_count) * 100;
                $patient->weekly_compliance = round($compliance);
                $patient->missed_count = $patient->total_count - $patient->completed_count;
                return $compliance < 80;
            })
            ->sortBy('weekly_compliance')
            ->take(10);

        return $patients;
    }

    /**
     * Get today's compliance stats
     */
    protected function getTodayStats()
    {
        $today = Carbon::today();

        $todayLogs = ComplianceLog::whereDate('scheduled_date', $today)->get();

        return [
            'total' => $todayLogs->count(),
            'completed' => $todayLogs->where('status', 'completed')->count(),
            'pending' => $todayLogs->where('status', 'pending')->count(),
            'missed' => $todayLogs->where('status', 'missed')->count(),
        ];
    }

    /**
     * Get email stats for today
     */
    protected function getEmailStats()
    {
        $today = Carbon::today();

        $todayReminders = ScheduleReminder::whereDate('reminder_date', $today)->get();

        return [
            'sent' => $todayReminders->where('status', 'sent')->count(),
            'pending' => $todayReminders->where('status', 'pending')->count(),
            'failed' => $todayReminders->where('status', 'failed')->count(),
        ];
    }
}
