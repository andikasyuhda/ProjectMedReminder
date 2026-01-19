<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ComplianceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoryController extends Controller
{
    /**
     * Show compliance history
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Default to last 7 days
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date')) 
            : Carbon::now()->subDays(6)->startOfDay();
        
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now()->endOfDay();

        // Get daily summaries
        $dailySummaries = [];
        $currentDate = $endDate->copy();

        while ($currentDate->gte($startDate)) {
            $dayLogs = ComplianceLog::with(['schedule.medicine'])
                ->where('user_id', $user->id)
                ->whereDate('scheduled_date', $currentDate)
                ->get();

            $total = $dayLogs->count();
            $completed = $dayLogs->where('status', 'completed')->count();
            $missed = $dayLogs->where('status', 'missed')->count();
            $pending = $dayLogs->where('status', 'pending')->count();

            $dailySummaries[] = [
                'date' => $currentDate->copy(),
                'total' => $total,
                'completed' => $completed,
                'missed' => $missed,
                'pending' => $pending,
                'percentage' => $total > 0 ? round(($completed / max($total - $pending, 1)) * 100) : 0,
                'logs' => $dayLogs,
            ];

            $currentDate->subDay();
        }

        // Overall stats
        $allLogs = ComplianceLog::where('user_id', $user->id)
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->whereIn('status', ['completed', 'missed'])
            ->get();

        $overallTotal = $allLogs->count();
        $overallCompleted = $allLogs->where('status', 'completed')->count();
        $overallCompliance = $overallTotal > 0 ? round(($overallCompleted / $overallTotal) * 100) : 0;

        return view('patient.history', compact(
            'dailySummaries',
            'startDate',
            'endDate',
            'overallTotal',
            'overallCompleted',
            'overallCompliance'
        ));
    }
}
