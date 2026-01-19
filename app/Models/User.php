<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'medical_record_number',
        'name',
        'email',
        'password',
        'role',
        'phone',
        'birth_date',
        'gender',
        'address',
        'blood_pressure_target',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is patient
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Get medicine schedules for this patient
     */
    public function medicineSchedules(): HasMany
    {
        return $this->hasMany(MedicineSchedule::class);
    }

    /**
     * Get schedules created by this admin
     */
    public function createdSchedules(): HasMany
    {
        return $this->hasMany(MedicineSchedule::class, 'created_by');
    }

    /**
     * Get compliance logs for this patient
     */
    public function complianceLogs(): HasMany
    {
        return $this->hasMany(ComplianceLog::class);
    }

    /**
     * Get schedule reminders for this patient
     */
    public function scheduleReminders(): HasMany
    {
        return $this->hasMany(ScheduleReminder::class);
    }

    /**
     * Calculate compliance rate for this patient
     */
    public function getComplianceRateAttribute(): float
    {
        $totalLogs = $this->complianceLogs()->whereIn('status', ['completed', 'missed'])->count();
        
        if ($totalLogs === 0) {
            return 0;
        }

        $completedLogs = $this->complianceLogs()->where('status', 'completed')->count();
        
        return round(($completedLogs / $totalLogs) * 100, 1);
    }

    /**
     * Get age from birth date
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }

        return $this->birth_date->age;
    }

    /**
     * Generate medical record number
     */
    public static function generateMedicalRecordNumber(): string
    {
        $year = date('Y');
        $lastRecord = self::where('medical_record_number', 'like', "RM-{$year}-%")
            ->orderBy('medical_record_number', 'desc')
            ->first();

        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord->medical_record_number, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "RM-{$year}-{$newNumber}";
    }
}
