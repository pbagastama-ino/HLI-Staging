<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Publication extends Model
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
        'text',
        'image',
        'image_url',
        'category',
        'published_date',
        'status',
        'featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'published_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'excerpt',
        'category_display',
        'image_url',
    ];

    /**
     * Boot method to generate slug automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publication) {
            if (empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
                
                // Ensure unique slug
                $originalSlug = $publication->slug;
                $counter = 1;
                while (static::where('slug', $publication->slug)->exists()) {
                    $publication->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });

        static::updating(function ($publication) {
            if ($publication->isDirty('title') && empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
                
                // Ensure unique slug
                $originalSlug = $publication->slug;
                $counter = 1;
                while (static::where('slug', $publication->slug)->where('id', '!=', $publication->id)->exists()) {
                    $publication->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });
    }

    /**
     * Get the user who created this publication
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this publication
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the status badge color for display
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'archived' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get the category display name
     */
    public function getCategoryDisplayAttribute(): string
    {
        return match($this->category) {
            'press-release' => 'Press Release',
            'company-activities' => 'Company Activities',
            'life-at-hli' => 'Life at HLI',
            default => ucfirst(str_replace('-', ' ', $this->category))
        };
    }

    /**
     * Scope for published publications
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured publications
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope for publications by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for searching publications
     */
    public function scopeSearch($query, string $search)
    {
        $searchTerm = strtolower($search);
        return $query->where(function ($q) use ($searchTerm) {
            $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(text) LIKE ?', ["%{$searchTerm}%"])
              ->orWhereRaw('LOWER(category) LIKE ?', ["%{$searchTerm}%"]);
        });
    }

    /**
     * Scope for ordering by published date
     */
    public function scopeOrderByPublished($query)
    {
        return $query->orderBy('featured', 'desc')
                    ->orderBy('published_date', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute(): string
    {
        if ($this->published_date) {
            return $this->published_date->format('d F Y');
        }
        return $this->created_at->format('d F Y');
    }

    /**
     * Get excerpt of text
     */
    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->text), 30);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://via.placeholder.com/400x300/4D9F95/FFFFFF?text=No+Image';
    }
}
