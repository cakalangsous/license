<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class License extends Model
{
    protected $fillable = [
        'uuid',
        'product_id',
        'marketplace_id',
        'purchase_code',
        'buyer_email',
        'buyer_name',
        'buyer_username',
        'license_type',
        'purchased_at',
        'supported_until',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'supported_until' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($license) {
            if (empty($license->uuid)) {
                $license->uuid = (string) Str::uuid();
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function activations(): HasMany
    {
        return $this->hasMany(Activation::class);
    }

    public function activeActivations(): HasMany
    {
        return $this->hasMany(Activation::class)->where('status', 'active');
    }

    public function productionActivations(): HasMany
    {
        return $this->hasMany(Activation::class)
            ->where('status', 'active')
            ->where('is_local', false);
    }

    public function localActivations(): HasMany
    {
        return $this->hasMany(Activation::class)
            ->where('status', 'active')
            ->where('is_local', true);
    }

    public function getLocalActivationCount(): int
    {
        return $this->localActivations()->count();
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class);
    }

    public function getDomainLimit(): int
    {
        return $this->product->getDomainLimit($this->license_type);
    }

    public function getUsedDomainCount(): int
    {
        return $this->productionActivations()->count();
    }

    public function canActivateOn(string $domain, bool $isLocal): bool
    {
        // Local domains don't count toward limit
        if ($isLocal) {
            return true;
        }

        // Check if already activated on this domain
        $existingActivation = $this->activations()
            ->where('domain', $domain)
            ->where('status', 'active')
            ->first();

        if ($existingActivation) {
            return true; // Already activated, just refresh
        }

        // Check domain limit
        return $this->getUsedDomainCount() < $this->getDomainLimit();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    public function hasSupportAccess(): bool
    {
        if (!$this->supported_until) {
            return true; // Lifetime support
        }

        return $this->supported_until->isFuture();
    }

    /**
     * Scope: Licenses with support expiring within X days
     */
    public function scopeExpiringSupport($query, int $days = 30)
    {
        return $query->whereNotNull('supported_until')
                     ->whereBetween('supported_until', [now(), now()->addDays($days)]);
    }

    /**
     * Scope: Licenses with expired support
     */
    public function scopeExpiredSupport($query)
    {
        return $query->whereNotNull('supported_until')
                     ->where('supported_until', '<', now());
    }

    /**
     * Scope: Licenses with active support
     */
    public function scopeActiveSupport($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('supported_until')
              ->orWhere('supported_until', '>', now());
        });
    }

    /**
     * Scope: Licenses with lifetime support
     */
    public function scopeLifetimeSupport($query)
    {
        return $query->whereNull('supported_until');
    }

    /**
     * Get support status attribute
     */
    public function getSupportStatusAttribute(): string
    {
        if (!$this->supported_until) {
            return 'lifetime';
        }
        
        if ($this->supported_until->isPast()) {
            return 'expired';
        }
        
        if ($this->supported_until->lt(now()->addDays(30))) {
            return 'expiring';
        }
        
        return 'active';
    }
}
