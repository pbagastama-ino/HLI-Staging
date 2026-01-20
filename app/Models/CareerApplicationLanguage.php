<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationLanguage extends Model
{
    use HasFactory;

    protected $table = 'career_application_languages';

    protected $fillable = [
        'career_application_id',
        'language_name',
        'proficiency_level',
        'speaking_level',
        'writing_level',
        'reading_level',
        'listening_level',
        'certificate_name',
        'certificate_path',
        'certificate_date',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'certificate_date' => 'date',
    ];

    /**
     * Get the career application this language belongs to
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
            'native' => 'Native',
            'fluent' => 'Fluent',
            default => 'Unknown'
        };
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('language_name');
    }

    /**
     * Scope for specific proficiency level
     */
    public function scopeByProficiency($query, string $level)
    {
        return $query->where('proficiency_level', $level);
    }
}