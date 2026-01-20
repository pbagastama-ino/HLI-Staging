<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplicationCertification extends Model
{
    use HasFactory;

    protected $table = 'career_application_certifications';

    protected $fillable = [
        'career_application_id',
        'certification_name',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'certification_number',
        'credential_id',
        'certificate_path',
        'certification_type',
        'status',
        'description',
        'notes',
        'is_verified',
        'sort_order',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the career application this certification belongs to
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
        return $query->orderBy('sort_order')->orderBy('issue_date', 'desc');
    }

    /**
     * Scope for active certifications
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for expired certifications
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere(function($q) {
                        $q->where('expiry_date', '<', now())
                          ->where('status', 'active');
                    });
    }

    /**
     * Scope for verified certifications
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Check if certification is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date < now();
    }

    /**
     * Get certification type display name
     */
    public function getCertificationTypeDisplayAttribute(): string
    {
        return match($this->certification_type) {
            'professional' => 'Professional',
            'technical' => 'Technical',
            'language' => 'Language',
            'academic' => 'Academic',
            'industry' => 'Industry',
            'software' => 'Software',
            'safety' => 'Safety',
            'management' => 'Management',
            'other' => 'Other',
            default => 'Unknown'
        };
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'expired' => 'Expired',
            'suspended' => 'Suspended',
            'revoked' => 'Revoked',
            default => 'Unknown'
        };
    }
}