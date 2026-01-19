<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'generic_name',
        'dosage_form',
        'strength',
        'category',
        'description',
        'side_effects',
        'contraindications',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get schedules using this medicine
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(MedicineSchedule::class);
    }

    /**
     * Get full name with strength
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->strength}";
    }

    /**
     * Generate medicine code
     */
    public static function generateCode(): string
    {
        $lastMedicine = self::orderBy('code', 'desc')->first();

        if ($lastMedicine) {
            $lastNumber = (int) substr($lastMedicine->code, 4);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "OBT-{$newNumber}";
    }

    /**
     * Scope for active medicines
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get category badge color
     */
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'Antihipertensi' => 'danger',
            'Diuretik' => 'info',
            'ACE Inhibitor' => 'warning',
            'Beta Blocker' => 'primary',
            'Calcium Channel Blocker' => 'success',
            default => 'secondary',
        };
    }
}
