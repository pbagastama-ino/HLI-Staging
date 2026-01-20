<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * Get all jobs for this department
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(CareerJob::class);
    }

    /**
     * Get active jobs for this department
     */
    public function activeJobs(): HasMany
    {
        return $this->hasMany(CareerJob::class)->where('status', 'published');
    }

    /**
     * Get the job count for this department
     */
    public function getJobCountAttribute(): int
    {
        try {
            return $this->jobs()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get the active job count for this department
     */
    public function getActiveJobCountAttribute(): int
    {
        try {
            return $this->activeJobs()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Scope for active departments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope for searching departments
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
              ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);
        });
    }
}
