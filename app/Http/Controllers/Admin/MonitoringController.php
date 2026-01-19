<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ComplianceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Display monitoring dashboard
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : $today;

        // Get all patients with today's compliance
        $patients = User::where('role', 'patient')
            ->where('is_active', true)
            ->with(['complianceLogs' => function ($query) use ($date) {
                $query->whereDate('scheduled_date', $date)
                    ->with('schedule.medicine');
            }])
            ->get()
            ->map(function ($patient) {
                $logs = $patient->complianceLogs;
                $total = $logs->count();
                $completed = $logs->where('status', 'completed')->count();
                $missed = $logs->where('status', 'missed')->count();
                $pending = $logs->where('status', 'pending')->count();

                $patient->day_total = $total;
                $patient->day_completed = $completed;
                $patient->day_missed = $missed;
                $patient->day_pending = $pending;
                $patient->day_compliance = $total > 0 
                    ? round(($completed / max($total - $pending, 1)) * 100) 
                    : 0;

                return $patient;
            })
            ->filter(fn($p) => $p->day_total > 0)
            ->sortBy('day_compliance');

        return view('admin.monitoring.index', compact('patients', 'date'));
    }

    /**
     * Show patient detail monitoring
     */
    public function show(User $patient, Request $request)
    {
        if ($patient->role !== 'patient') {
            abort(404);
        }

        $today = Carbon::today();
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->subDays(6);
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : $today;

        // Get compliance logs for date range
        $logs = ComplianceLog::where('user_id', $patient->id)
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->with('schedule.medicine')
            ->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->get();

        // Group by date
        $dailyData = [];
        $currentDate = $endDate->copy();

        while ($currentDate->gte($startDate)) {
            $dayLogs = $logs->filter(fn($log) => $log->scheduled_date->isSameDay($currentDate));
            
            $total = $dayLogs->count();
            $completed = $dayLogs->where('status', 'completed')->count();
            $missed = $dayLogs->where('status', 'missed')->count();

            $dailyData[] = [
                'date' => $currentDate->copy(),
                'total' => $total,
                'completed' => $completed,
                'missed' => $missed,
                'compliance' => $total > 0 ? round(($completed / $total) * 100) : 0,
                'logs' => $dayLogs,
            ];

            $currentDate->subDay();
        }

        // Overall stats
        $overallTotal = $logs->whereIn('status', ['completed', 'missed'])->count();
        $overallCompleted = $logs->where('status', 'completed')->count();
        $overallCompliance = $overallTotal > 0 ? round(($overallCompleted / $overallTotal) * 100) : 0;

        return view('admin.monitoring.show', compact(
            'patient',
            'dailyData',
            'startDate',
            'endDate',
            'overallTotal',
            'overallCompleted',
            'overallCompliance'
        ));
    }
}
