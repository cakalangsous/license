<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'license_id',
        'activation_id',
        'domain',
        'app_name',
        'ip_address',
        'request_type',
        'status',
        'failure_reason',
        'request_data',
        'created_at',
    ];

    protected $casts = [
        'request_data' => 'array',
        'created_at' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function activation(): BelongsTo
    {
        return $this->belongsTo(Activation::class);
    }

    public static function logVerification(
        string $domain,
        string $ipAddress,
        string $requestType,
        string $status,
        ?int $licenseId = null,
        ?int $activationId = null,
        ?string $failureReason = null,
        ?array $requestData = null,
        ?string $appName = null
    ): self {
        return self::create([
            'license_id' => $licenseId,
            'activation_id' => $activationId,
            'domain' => $domain,
            'app_name' => $appName,
            'ip_address' => $ipAddress,
            'request_type' => $requestType,
            'status' => $status,
            'failure_reason' => $failureReason,
            'request_data' => $requestData,
            'created_at' => now(),
        ]);
    }
}
