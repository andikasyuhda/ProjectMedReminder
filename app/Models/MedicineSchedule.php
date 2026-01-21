<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class MedicineSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicine_id',
        'dosage',
        'frequency_per_day',
        'time_slots',
        'instruction',
        'start_date',
        'end_date',
        'notes',
        'is_active',
        'send_email_reminder',
        'created_by',
    ];

    protected $casts = [
        'time_slots' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'send_email_reminder' => 'boolean',
    ];

    /**
     * Get the patient for this schedule
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias for user relationship
     */
    public function patient(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Get the medicine for this schedule
     */
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the admin who created this schedule
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get compliance logs for this schedule
     */
    public function complianceLogs(): HasMany
    {
        return $this->hasMany(ComplianceLog::class, 'schedule_id');
    }

    /**
     * Get schedule reminders
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(ScheduleReminder::class, 'schedule_id');
    }

    /**
     * Calculate days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        return max(0, Carbon::now()->startOfDay()->diffInDays($this->end_date, false));
    }

    /**
     * Check if schedule is currently active
     */
    public function getIsCurrentlyActiveAttribute(): bool
    {
        $today = Carbon::today();
        return $this->is_active && 
               $today->gte($this->start_date) && 
               $today->lte($this->end_date);
    }

    /**
     * Get formatted time slots
     */
    public function getFormattedTimeSlotsAttribute(): string
    {
        return implode(', ', $this->time_slots ?? []);
    }

    /**
     * Get period string
     */
    public function getPeriodAttribute(): string
    {
        return $this->start_date->format('d M') . ' - ' . $this->end_date->format('d M Y');
    }

    /**
     * Scope for active schedules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', Carbon::today())
            ->where('end_date', '>=', Carbon::today());
    }

    /**
     * Scope for patient
     */
    public function scopeForPatient($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
