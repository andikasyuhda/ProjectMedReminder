<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ComplianceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'user_id',
        'scheduled_date',
        'scheduled_time',
        'status',
        'taken_at',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'taken_at' => 'datetime',
    ];

    /**
     * Get the schedule for this log
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MedicineSchedule::class, 'schedule_id');
    }

    /**
     * Get the patient for this log
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for completed logs
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for missed logs
     */
    public function scopeMissed($query)
    {
        return $query->where('status', 'missed');
    }

    /**
     * Scope for pending logs
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for today's logs
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', today());
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_date', [$startDate, $endDate]);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed' => 'success',
            'pending' => 'info',
            'missed' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'completed' => 'Selesai',
            'pending' => 'Menunggu',
            'missed' => 'Terlewat',
            default => $this->status,
        };
    }

    /**
     * Check if this log is for current time slot
     */
    public function getIsCurrentAttribute(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $now = Carbon::now();
        $scheduledDateTime = Carbon::parse($this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time);
        
        // Within 30 minutes before and after scheduled time
        return $now->between(
            $scheduledDateTime->copy()->subMinutes(30),
            $scheduledDateTime->copy()->addMinutes(30)
        );
    }

    /**
     * Check if this log is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $scheduledDateTime = Carbon::parse($this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time);

        return Carbon::now()->gt($scheduledDateTime->copy()->addMinutes(30));
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(?string $notes = null): bool
    {
        return $this->update([
            'status' => 'completed',
            'taken_at' => Carbon::now(),
            'notes' => $notes,
        ]);
    }

    /**
     * Mark as missed
     */
    public function markAsMissed(): bool
    {
        return $this->update([
            'status' => 'missed',
        ]);
    }
}
