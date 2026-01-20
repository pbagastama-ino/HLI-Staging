<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationEducation extends Model
{
    use HasFactory;

    protected $table = 'career_application_educations';

    protected $fillable = [
        'career_application_id',
        'level',
        'school_name',
        'faculty',
        'major',
        'start_year',
        'end_year',
        'graduate_year',
        'gpa',
        'certificate_path',
        'description',
        'is_current',
        'sort_order',
    ];

    protected $casts = [
        'gpa' => 'decimal:2',
        'is_current' => 'boolean',
    ];

    /**
     * Get the career application this education belongs to
     */
    public function careerApplication(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class);
    }

    /**
     * Get the education level display name
     */
    public function getEducationLevelAttribute(): string
    {
        return match($this->level) {
            'smk1' => 'SMK 1',
            'smk2' => 'SMK 2', 
            'd3-1' => 'D3 1',
            'd3-2' => 'D3 2',
            's1' => 'S1',
            's2' => 'S2',
            's3' => 'S3',
            default => 'Unknown'
        };
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('end_year', 'desc');
    }

    /**
     * Scope for current education
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }
}