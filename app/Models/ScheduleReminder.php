<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'user_id',
        'reminder_date',
        'reminder_time',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'reminder_date' => 'date',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the schedule for this reminder
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MedicineSchedule::class, 'schedule_id');
    }

    /**
     * Get the patient for this reminder
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending reminders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for sent reminders
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed reminders
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for today's reminders
     */
    public function scopeToday($query)
    {
        return $query->whereDate('reminder_date', today());
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'sent' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'sent' => 'Terkirim',
            'pending' => 'Menunggu',
            'failed' => 'Gagal',
            default => $this->status,
        };
    }
}
