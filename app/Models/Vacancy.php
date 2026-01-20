<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'department_name',
        'employee_benefit',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this vacancy
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this vacancy
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all applications for this vacancy
     */
    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class, 'applied_position', 'title');
    }

    /**
     * Get the application count
     */
    public function getApplicationCountAttribute(): int
    {
        return $this->applications()->count();
    }

    /**
     * Scope for searching vacancies
     */
    public function scopeSearch($query, string $search)
    {
        $searchTerm = strtolower($search);
        return $query->where(function ($q) use ($searchTerm) {
            $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(requirements) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(department_name) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(employee_benefit) LIKE ?', ["%{$searchTerm}%"]);
        });
    }

    /**
     * Scope for ordering by creation date
     */
    public function scopeOrderByCreated($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for filtering active vacancies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
