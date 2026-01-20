<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CareerJob extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'department_id',
        'employment_type',
        'experience_level',
        'location',
        'remote_allowed',
        'salary_range',
        'application_deadline',
        'max_applications',
        'application_instructions',
        'status',
        'featured',
        'priority',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'remote_allowed' => 'boolean',
        'featured' => 'boolean',
        'application_deadline' => 'date',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot method to generate slug automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (empty($job->slug)) {
                $job->slug = Str::slug($job->title);
                
                // Ensure unique slug
                $originalSlug = $job->slug;
                $counter = 1;
                while (static::where('slug', $job->slug)->exists()) {
                    $job->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });

        static::updating(function ($job) {
            if ($job->isDirty('title') && empty($job->slug)) {
                $job->slug = Str::slug($job->title);
                
                // Ensure unique slug
                $originalSlug = $job->slug;
                $counter = 1;
                while (static::where('slug', $job->slug)->where('id', '!=', $job->id)->exists()) {
                    $job->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });
    }

    /**
     * Get the department this job belongs to
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the user who created this job
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this job
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all applications for this job
     */
    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class, 'applied_position', 'title');
    }

    /**
     * Get the status badge color for display
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'closed' => 'yellow',
            'archived' => 'red',
            default => 'gray'
        };
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
            default => ucfirst($this->employment_type)
        };
    }

    /**
     * Get the experience level display name
     */
    public function getExperienceLevelDisplayAttribute(): string
    {
        return match($this->experience_level) {
            'entry' => 'Entry Level',
            'mid' => 'Mid Level',
            'senior' => 'Senior Level',
            'executive' => 'Executive Level',
            default => ucfirst($this->experience_level)
        };
    }

    /**
     * Check if the job is currently accepting applications
     */
    public function isAcceptingApplications(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->application_deadline && $this->application_deadline->isPast()) {
            return false;
        }

        if ($this->max_applications && $this->applications()->count() >= $this->max_applications) {
            return false;
        }

        return true;
    }

    /**
     * Get the application count
     */
    public function getApplicationCountAttribute(): int
    {
        return $this->applications()->count();
    }

    /**
     * Scope for published jobs
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function ($q) {
                        $q->whereNull('application_deadline')
                          ->orWhere('application_deadline', '>=', now());
                    });
    }

    /**
     * Scope for featured jobs
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope for jobs by department
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope for jobs by employment type
     */
    public function scopeByEmploymentType($query, string $employmentType)
    {
        return $query->where('employment_type', $employmentType);
    }

    /**
     * Scope for jobs by experience level
     */
    public function scopeByExperienceLevel($query, string $experienceLevel)
    {
        return $query->where('experience_level', $experienceLevel);
    }

    /**
     * Scope for remote jobs
     */
    public function scopeRemote($query)
    {
        return $query->where('remote_allowed', true);
    }

    /**
     * Scope for searching jobs
     */
    public function scopeSearch($query, string $search)
    {
        $searchTerm = strtolower($search);
        return $query->where(function ($q) use ($searchTerm) {
            $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(location) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(employment_type) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(experience_level) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereHas('department', function ($deptQuery) use ($searchTerm) {
                  $deptQuery->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
              });
        });
    }

    /**
     * Scope for ordering by priority
     */
    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('priority', 'desc')
                    ->orderBy('featured', 'desc')
                    ->orderBy('published_at', 'desc');
    }
}
