<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationExperience extends Model
{
    use HasFactory;

    protected $table = 'career_application_experiences';

    protected $fillable = [
        'career_application_id',
        'company_name',
        'position',
        'job_description',
        'start_year',
        'end_year',
        'employment_type',
        'salary_range',
        'reasons_for_leaving',
        'supervisor_name',
        'supervisor_contact',
        'achievements',
        'responsibilities',
        'is_current',
        'sort_order',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    /**
     * Get the career application this experience belongs to
     */
    public function careerApplication(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class);
    }

    /**
     * Get the employment type display name
     */
    public function getEmploymentTypeDisplayAttribute(): string
    {
        return match($this->employment_type) {
            'full-time' => 'Full Time',
            'part-time' => 'Part Time',
            'contract' => 'Contract',
            'internship' => 'Internship',
            'freelance' => 'Freelance',
            default => ucfirst($this->employment_type ?? 'Unknown')
        };
    }

    /**
     * Get the duration of experience in years
     */
    public function getDurationAttribute(): float
    {
        if (!$this->start_year) return 0;
        
        $endYear = $this->is_current ? date('Y') : ($this->end_year ?? date('Y'));
        $startYear = (int) $this->start_year;
        $endYear = (int) $endYear;
        
        return max(0, $endYear - $startYear);
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('start_year', 'desc');
    }

    /**
     * Scope for current experience
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope for specific employment type
     */
    public function scopeByEmploymentType($query, string $type)
    {
        return $query->where('employment_type', $type);
    }
}