<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationAchievement extends Model
{
    use HasFactory;

    protected $table = 'career_application_achievements';

    protected $fillable = [
        'career_application_id',
        'title',
        'description',
        'organization',
        'achievement_date',
        'year',
        'category',
        'certificate_path',
        'verification_url',
        'impact',
        'sort_order',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    /**
     * Get the career application this achievement belongs to
     */
    public function careerApplication(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class);
    }

    /**
     * Get the category display name
     */
    public function getCategoryDisplayAttribute(): string
    {
        return match($this->category) {
            'academic' => 'Academic',
            'professional' => 'Professional',
            'personal' => 'Personal',
            'sports' => 'Sports',
            'volunteer' => 'Volunteer',
            'leadership' => 'Leadership',
            'innovation' => 'Innovation',
            default => ucfirst($this->category ?? 'Other')
        };
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('achievement_date', 'desc');
    }

    /**
     * Scope for specific category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for recent achievements
     */
    public function scopeRecent($query, int $years = 5)
    {
        return $query->where('achievement_date', '>=', now()->subYears($years));
    }
}