<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ComplianceLog;
use App\Models\ScheduleReminder;
use App\Services\ResendMailService;
use Carbon\Carbon;

class SendMedicationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medication:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for upcoming medication schedules (30 minutes before)';

    protected $resendService;

    public function __construct(ResendMailService $resendService)
    {
        parent::__construct();
        $this->resendService = $resendService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking for upcoming medication schedules...');

        $now = Carbon::now();
        $reminderTime = $now->copy()->addMinutes(30);

        // Find all pending compliance logs scheduled for 30 minutes from now
        // Only for schedules with email reminders enabled
        $upcomingLogs = ComplianceLog::with(['user', 'schedule.medicine'])
            ->where('status', 'pending')
            ->whereDate('scheduled_date', $reminderTime->toDateString())
            ->whereHas('schedule', function($query) {
                $query->where('send_email_reminder', true)
                      ->where('is_active', true);
            })
            ->get()
            ->filter(function ($log) use ($reminderTime, $now) {
                $scheduledDateTime = Carbon::parse(
                    $log->scheduled_date->format('Y-m-d') . ' ' . $log->scheduled_time
                );

                // Check if scheduled time is within 30-32 minutes from now
                // (2 minute window to catch the schedule)
                $diff = $now->diffInMinutes($scheduledDateTime, false);
                return $diff >= 30 && $diff <= 32;
            });

        if ($upcomingLogs->isEmpty()) {
            $this->info('✅ No upcoming medications to remind at this time.');
            return 0;
        }

        $this->info("📧 Found {$upcomingLogs->count()} reminder(s) to send...");

        $sentCount = 0;
        $failedCount = 0;

        foreach ($upcomingLogs as $log) {
            try {
                // Check if reminder already sent for this log
                $existingReminder = ScheduleReminder::where('compliance_log_id', $log->id)
                    ->whereDate('reminder_date', $now->toDateString())
                    ->first();

                if ($existingReminder && $existingReminder->status === 'sent') {
                    $this->warn("⏭️  Skipping: Reminder already sent for {$log->user->name}");
                    continue;
                }

                // Send reminder email
                $result = $this->resendService->sendMedicationReminder(
                    $log->user,
                    $log->schedule,
                    Carbon::parse($log->scheduled_time)->format('H:i')
                );

                if ($result) {
                    // Create or update reminder record
                    ScheduleReminder::updateOrCreate(
                        [
                            'compliance_log_id' => $log->id,
                            'reminder_date' => $now->toDateString(),
                        ],
                        [
                            'schedule_id' => $log->schedule_id,
                            'user_id' => $log->user_id,
                            'reminder_time' => $now->format('H:i:s'),
                            'scheduled_time' => $log->scheduled_time,
                            'status' => 'sent',
                            'sent_at' => $now,
                        ]
                    );

                    $this->info("✅ Sent to: {$log->user->name} ({$log->user->email}) - {$log->schedule->medicine->name}");
                    $sentCount++;
                } else {
                    $this->error("❌ Failed to send to: {$log->user->name}");
                    $failedCount++;
                }

            } catch (\Exception $e) {
                $this->error("❌ Error sending reminder: " . $e->getMessage());
                $failedCount++;
            }
        }

        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("   ✅ Sent: {$sentCount}");
        if ($failedCount > 0) {
            $this->error("   ❌ Failed: {$failedCount}");
        }

        return 0;
    }
}
