<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class CareerApplication extends Model
{
    use HasFactory;

    /**
     * Boot the model and add event listeners
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set updated_by when the model is updated
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Personal Data
        'full_name',
        'nationality',
        'sex',
        'date_of_birth',
        'place_of_birth',
        'marital_status',
        'id_address',
        'current_address',
        'same_as_id_address',
        'phone_number',
        'email',
        'linkedin_profile',
        'social_media',
        
        // Application Status
        'status',
        'read_status',
        'read_at',
        'notes',
        'applied_position',
        'vacancy_id',
        'current_salary',
        'reason_for_leaving',
        'application_source',
        'additional_comments',
        'privacy_policy_agreed',
        'privacy_policy_agreed_at',
        'uploaded_files',
        'resume_path',
        'updated_by',
        'talent_pool',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'same_as_id_address' => 'boolean',
        'privacy_policy_agreed' => 'boolean',
        'privacy_policy_agreed_at' => 'datetime',
        'read_status' => 'boolean',
        'read_at' => 'datetime',
        'uploaded_files' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'talent_pool' => 'boolean',
    ];

    /**
     * Get the status badge color for display
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'unread' => 'yellow',
            'read' => 'gray',
            'shortlisted' => 'blue',
            'interview' => 'purple',
            'not_suitable' => 'red',
            default => 'gray'
        };
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by read status
     */
    public function scopeByReadStatus($query, bool $read = true)
    {
        return $query->where('read_status', $read);
    }

    /**
     * Scope for unread applications
     */
    public function scopeUnread($query)
    {
        return $query->where('read_status', false)->orWhere('status', 'unread');
    }

    /**
     * Scope for recent applications
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for searching applications
     */
    public function scopeSearch($query, string $search)
    {
        $dbDriver = $query->getConnection()->getDriverName();
        $searchTerm = "%{$search}%";
        
        return $query->where(function ($q) use ($search, $searchTerm, $dbDriver) {
            // Use case-insensitive search based on database driver
            if ($dbDriver === 'pgsql') {
                $q->where('full_name', 'ilike', $searchTerm)
                  ->orWhere('email', 'ilike', $searchTerm)
                  ->orWhere('phone_number', 'ilike', $searchTerm)
                  ->orWhere('applied_position', 'ilike', $searchTerm);
            } else {
                // MySQL/MariaDB - use LOWER() for case-insensitive search
                $q->whereRaw('LOWER(full_name) LIKE ?', [strtolower($searchTerm)])
                  ->orWhereRaw('LOWER(email) LIKE ?', [strtolower($searchTerm)])
                  ->orWhereRaw('LOWER(phone_number) LIKE ?', [strtolower($searchTerm)])
                  ->orWhereRaw('LOWER(applied_position) LIKE ?', [strtolower($searchTerm)]);
            }
            
            // Date of birth search - Database compatible
            if ($dbDriver === 'pgsql') {
                $q->orWhereRaw("TO_CHAR(date_of_birth, 'DD/MM/YYYY') ILIKE ?", [$searchTerm])
                  ->orWhereRaw("TO_CHAR(date_of_birth, 'YYYY-MM-DD') ILIKE ?", [$searchTerm]);
            } else {
                // MySQL/MariaDB
                $q->orWhereRaw('DATE_FORMAT(date_of_birth, "%d/%m/%Y") LIKE ?', [$searchTerm])
                  ->orWhereRaw('DATE_FORMAT(date_of_birth, "%Y-%m-%d") LIKE ?', [$searchTerm]);
            }
            
            // Use joins instead of orWhereHas for better performance
            $q->orWhereExists(function ($expQuery) use ($searchTerm, $dbDriver) {
                $expQuery->select(DB::raw(1))
                    ->from('career_application_experiences')
                    ->whereColumn('career_application_experiences.career_application_id', 'career_applications.id')
                    ->where(function ($subQuery) use ($searchTerm, $dbDriver) {
                        if ($dbDriver === 'pgsql') {
                            $subQuery->where('career_application_experiences.company_name', 'ilike', $searchTerm)
                                     ->orWhere('career_application_experiences.position', 'ilike', $searchTerm);
                        } else {
                            $subQuery->whereRaw('LOWER(career_application_experiences.company_name) LIKE ?', [strtolower($searchTerm)])
                                     ->orWhereRaw('LOWER(career_application_experiences.position) LIKE ?', [strtolower($searchTerm)]);
                        }
                    });
            })
            ->orWhereExists(function ($eduQuery) use ($searchTerm, $dbDriver) {
                $eduQuery->select(DB::raw(1))
                    ->from('career_application_educations')
                    ->whereColumn('career_application_educations.career_application_id', 'career_applications.id')
                    ->where(function ($subQuery) use ($searchTerm, $dbDriver) {
                        if ($dbDriver === 'pgsql') {
                            $subQuery->where('career_application_educations.school_name', 'ilike', $searchTerm)
                                     ->orWhere('career_application_educations.major', 'ilike', $searchTerm)
                                     ->orWhere('career_application_educations.faculty', 'ilike', $searchTerm);
                        } else {
                            $subQuery->whereRaw('LOWER(career_application_educations.school_name) LIKE ?', [strtolower($searchTerm)])
                                     ->orWhereRaw('LOWER(career_application_educations.major) LIKE ?', [strtolower($searchTerm)])
                                     ->orWhereRaw('LOWER(career_application_educations.faculty) LIKE ?', [strtolower($searchTerm)]);
                        }
                    });
            })
            ->orWhereExists(function ($vacQuery) use ($searchTerm, $dbDriver) {
                $vacQuery->select(DB::raw(1))
                    ->from('vacancies')
                    ->whereColumn('vacancies.id', 'career_applications.vacancy_id')
                    ->where(function ($subQuery) use ($searchTerm, $dbDriver) {
                        if ($dbDriver === 'pgsql') {
                            $subQuery->where('vacancies.title', 'ilike', $searchTerm);
                        } else {
                            $subQuery->whereRaw('LOWER(vacancies.title) LIKE ?', [strtolower($searchTerm)]);
                        }
                    });
            });
        });
    }

    /**
     * Scope for filtering by talent pool status
     */
    public function scopeInTalentPool($query, bool $inPool = true)
    {
        return $query->where('talent_pool', $inPool);
    }

    /**
     * Get the vacancy this application is for
     */
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
    }

    /**
     * Get all references for this application
     */
    public function references(): HasMany
    {
        return $this->hasMany(CareerApplicationReference::class)->ordered();
    }

    /**
     * Get all educations for this application
     */
    public function educations(): HasMany
    {
        return $this->hasMany(CareerApplicationEducation::class)->ordered();
    }

    /**
     * Get all languages for this application
     */
    public function languages(): HasMany
    {
        return $this->hasMany(CareerApplicationLanguage::class)->ordered();
    }

    /**
     * Get all experiences for this application
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(CareerApplicationExperience::class)->ordered();
    }

    /**
     * Get all achievements for this application
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(CareerApplicationAchievement::class)->ordered();
    }

    /**
     * Get all skills for this application
     */
    public function skills(): HasMany
    {
        return $this->hasMany(CareerApplicationSkill::class)->ordered();
    }

    /**
     * Get all certifications for this application
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(CareerApplicationCertification::class)->ordered();
    }

    /**
     * Get the user who last updated this application
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the highest education level
     */
    public function getHighestEducationAttribute()
    {
        return $this->educations()->orderByRaw("
            CASE level 
                WHEN 's3' THEN 7
                WHEN 's2' THEN 6
                WHEN 's1' THEN 5
                WHEN 'd3-2' THEN 4
                WHEN 'd3-1' THEN 3
                WHEN 'smk2' THEN 2
                WHEN 'smk1' THEN 1
                ELSE 0
            END DESC
        ")->first();
    }

    /**
     * Get current work experience
     */
    public function getCurrentExperienceAttribute()
    {
        return $this->experiences()->current()->first();
    }

    /**
     * Get total years of experience
     */
    public function getTotalExperienceAttribute(): float
    {
        return $this->experiences()->sum('duration');
    }
}