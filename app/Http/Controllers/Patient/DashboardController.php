<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ComplianceLog;
use App\Models\MedicineSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show patient dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Get active schedules for today
        $activeSchedules = MedicineSchedule::with(['medicine'])
            ->forPatient($user->id)
            ->active()
            ->get();

        // Get today's compliance logs
        $todayLogs = ComplianceLog::with(['schedule.medicine'])
            ->where('user_id', $user->id)
            ->whereDate('scheduled_date', $today)
            ->orderBy('scheduled_time')
            ->get();

        // Calculate today's stats
        $todayTotal = $todayLogs->count();
        $todayCompleted = $todayLogs->where('status', 'completed')->count();
        $todayMissed = $todayLogs->where('status', 'missed')->count();
        $todayPending = $todayLogs->where('status', 'pending')->count();

        // Calculate weekly compliance
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $weeklyLogs = ComplianceLog::where('user_id', $user->id)
            ->whereBetween('scheduled_date', [$weekStart, $weekEnd])
            ->whereIn('status', ['completed', 'missed'])
            ->get();

        $weeklyTotal = $weeklyLogs->count();
        $weeklyCompleted = $weeklyLogs->where('status', 'completed')->count();
        $weeklyCompliance = $weeklyTotal > 0 ? round(($weeklyCompleted / $weeklyTotal) * 100) : 0;

        // Calculate streak
        $streak = $this->calculateStreak($user->id);

        return view('patient.dashboard', compact(
            'user',
            'todayLogs',
            'todayTotal',
            'todayCompleted',
            'todayMissed',
            'todayPending',
            'weeklyCompliance',
            'streak',
            'activeSchedules'
        ));
    }

    /**
     * Mark medicine as taken
     */
    public function markAsTaken(Request $request, ComplianceLog $log)
    {
        // Verify ownership
        if ($log->user_id !== Auth::id()) {
            abort(403);
        }

        $log->markAsCompleted($request->input('notes'));

        return back()->with('success', '✅ Obat berhasil ditandai sudah diminum!');
    }

    /**
     * Calculate consecutive days streak
     */
    protected function calculateStreak(int $userId): int
    {
        $streak = 0;
        $date = Carbon::yesterday();

        while (true) {
            $dayLogs = ComplianceLog::where('user_id', $userId)
                ->whereDate('scheduled_date', $date)
                ->get();

            if ($dayLogs->isEmpty()) {
                break;
            }

            $allCompleted = $dayLogs->every(fn($log) => $log->status === 'completed');

            if (!$allCompleted) {
                break;
            }

            $streak++;
            $date->subDay();
        }

        return $streak;
    }
}
