<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationSkill extends Model
{
    use HasFactory;

    protected $table = 'career_application_skills';

    protected $fillable = [
        'career_application_id',
        'skill_name',
        'proficiency_level',
        'category',
        'years_experience',
        'description',
        'certification_name',
        'certification_path',
        'certification_date',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'certification_date' => 'date',
    ];

    /**
     * Get the career application this skill belongs to
     */
    public function careerApplication(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class);
    }

    /**
     * Get the proficiency level display name
     */
    public function getProficiencyLevelDisplayAttribute(): string
    {
        return match($this->proficiency_level) {
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
            'expert' => 'Expert',
            default => 'Unknown'
        };
    }

    /**
     * Get the category display name
     */
    public function getCategoryDisplayAttribute(): string
    {
        return match($this->category) {
            'technical' => 'Technical',
            'soft' => 'Soft Skills',
            'language' => 'Language',
            'software' => 'Software',
            'hardware' => 'Hardware',
            'management' => 'Management',
            'design' => 'Design',
            'marketing' => 'Marketing',
            'sales' => 'Sales',
            default => ucfirst($this->category ?? 'Other')
        };
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('skill_name');
    }

    /**
     * Scope for specific proficiency level
     */
    public function scopeByProficiency($query, string $level)
    {
        return $query->where('proficiency_level', $level);
    }

    /**
     * Scope for specific category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for skills with certifications
     */
    public function scopeCertified($query)
    {
        return $query->whereNotNull('certification_name');
    }
}