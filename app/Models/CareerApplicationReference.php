<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationReference extends Model
{
    use HasFactory;

    protected $table = 'career_application_references';

    protected $fillable = [
        'career_application_id',
        'name',
        'organization',
        'phone',
        'email',
        'relationship',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the career application this reference belongs to
     */
    public function careerApplication(): BelongsTo
    {
        return $this->belongsTo(CareerApplication::class);
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}