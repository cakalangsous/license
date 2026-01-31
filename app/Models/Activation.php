<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activation extends Model
{
    protected $fillable = [
        'license_id',
        'domain',
        'is_local',
        'app_version',
        'php_version',
        'laravel_version',
        'server_ip',
        'activated_at',
        'last_verified_at',
        'status',
    ];

    protected $casts = [
        'is_local' => 'boolean',
        'activated_at' => 'datetime',
        'last_verified_at' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isDeactivated(): bool
    {
        return $this->status === 'deactivated';
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function markVerified(): void
    {
        $this->update(['last_verified_at' => now()]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => 'deactivated']);
    }

    public function block(): void
    {
        $this->update(['status' => 'blocked']);
    }

    public function getDaysSinceLastVerification(): int
    {
        if (!$this->last_verified_at) {
            return $this->activated_at->diffInDays(now());
        }

        return $this->last_verified_at->diffInDays(now());
    }
}
