<?php

namespace App\Services;

use App\Models\License;
use App\Models\Activation;
use App\Models\BlacklistedDomain;
use App\Models\VerificationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LicenseService
{
    /**
     * Verify a purchase code and return license info.
     */
    public function verify(string $purchaseCode): array
    {
        $license = License::where('purchase_code', $purchaseCode)
            ->with(['product', 'marketplace'])
            ->first();

        if (!$license) {
            return [
                'valid' => false,
                'error' => 'invalid_purchase_code',
                'message' => 'The purchase code is not valid or not found.',
            ];
        }

        if (!$license->isActive()) {
            return [
                'valid' => false,
                'error' => 'license_' . $license->status,
                'message' => 'This license has been ' . $license->status . '.',
            ];
        }

        return [
            'valid' => true,
            'license_type' => $license->license_type,
            'buyer' => $license->buyer_email,
            'supported_until' => $license->supported_until?->toIso8601String(),
            'domains_used' => $license->getUsedDomainCount(),
            'domains_limit' => $license->getDomainLimit(),
            'product' => [
                'name' => $license->product->name,
                'slug' => $license->product->slug,
                'version' => $license->product->current_version,
            ],
        ];
    }

    /**
     * Activate a license on a domain.
     */
    public function activate(
        string $purchaseCode,
        string $domain,
        bool $isLocal,
        ?string $appVersion = null,
        ?string $phpVersion = null,
        ?string $laravelVersion = null,
        ?string $serverIp = null
    ): array {
        // Check if domain is blacklisted
        if (BlacklistedDomain::isBlacklisted($domain)) {
            return [
                'valid' => false,
                'error' => 'domain_blacklisted',
                'message' => 'This domain has been blacklisted.',
            ];
        }

        $license = License::where('purchase_code', $purchaseCode)
            ->with('product')
            ->first();

        if (!$license) {
            return [
                'valid' => false,
                'error' => 'invalid_purchase_code',
                'message' => 'The purchase code is not valid or not found.',
            ];
        }

        if (!$license->isActive()) {
            return [
                'valid' => false,
                'error' => 'license_' . $license->status,
                'message' => 'This license has been ' . $license->status . '.',
            ];
        }

        // Check if can activate on this domain
        if (!$license->canActivateOn($domain, $isLocal)) {
            $activeDomains = $license->productionActivations()
                ->pluck('domain')
                ->toArray();

            return [
                'valid' => false,
                'error' => 'domain_limit_exceeded',
                'message' => "This license is already activated on {$license->getUsedDomainCount()} domain(s). Maximum allowed: {$license->getDomainLimit()}",
                'domains' => $activeDomains,
            ];
        }

        // Create or update activation
        $activation = Activation::updateOrCreate(
            [
                'license_id' => $license->id,
                'domain' => $domain,
            ],
            [
                'is_local' => $isLocal,
                'app_version' => $appVersion,
                'php_version' => $phpVersion,
                'laravel_version' => $laravelVersion,
                'server_ip' => $serverIp,
                'activated_at' => now(),
                'last_verified_at' => now(),
                'status' => 'active',
            ]
        );

        return [
            'valid' => true,
            'activation_id' => $activation->id,
            'license_type' => $license->license_type,
            'buyer' => $license->buyer_email,
            'supported_until' => $license->supported_until?->toIso8601String(),
            'domains_used' => $license->getUsedDomainCount(),
            'domains_limit' => $license->getDomainLimit(),
            'product' => [
                'name' => $license->product->name,
                'slug' => $license->product->slug,
                'version' => $license->product->current_version,
            ],
        ];
    }

    /**
     * Deactivate a license from a domain.
     */
    public function deactivate(string $purchaseCode, string $domain): array
    {
        $license = License::where('purchase_code', $purchaseCode)->first();

        if (!$license) {
            return [
                'valid' => false,
                'error' => 'invalid_purchase_code',
                'message' => 'The purchase code is not valid or not found.',
            ];
        }

        $activation = Activation::where('license_id', $license->id)
            ->where('domain', $domain)
            ->first();

        if (!$activation) {
            return [
                'valid' => false,
                'error' => 'activation_not_found',
                'message' => 'No activation found for this domain.',
            ];
        }

        $activation->deactivate();

        return [
            'valid' => true,
            'message' => 'Domain has been deactivated successfully.',
            'domains_used' => $license->fresh()->getUsedDomainCount(),
            'domains_limit' => $license->getDomainLimit(),
        ];
    }

    /**
     * Process heartbeat from an activated domain.
     */
    public function heartbeat(string $purchaseCode, string $domain): array
    {
        // Check if domain is blacklisted
        if (BlacklistedDomain::isBlacklisted($domain)) {
            return [
                'valid' => false,
                'error' => 'domain_blacklisted',
                'message' => 'This domain has been blacklisted.',
            ];
        }

        $license = License::where('purchase_code', $purchaseCode)
            ->with('product')
            ->first();

        if (!$license) {
            return [
                'valid' => false,
                'error' => 'invalid_purchase_code',
                'message' => 'The purchase code is not valid or not found.',
            ];
        }

        if (!$license->isActive()) {
            return [
                'valid' => false,
                'error' => 'license_' . $license->status,
                'message' => 'This license has been ' . $license->status . '.',
            ];
        }

        $activation = Activation::where('license_id', $license->id)
            ->where('domain', $domain)
            ->where('status', 'active')
            ->first();

        if (!$activation) {
            return [
                'valid' => false,
                'error' => 'activation_not_found',
                'message' => 'No active activation found for this domain. Please re-activate.',
            ];
        }

        // Update last verified time
        $activation->markVerified();

        return [
            'valid' => true,
            'license_type' => $license->license_type,
            'supported_until' => $license->supported_until?->toIso8601String(),
            'product' => [
                'name' => $license->product->name,
                'version' => $license->product->current_version,
            ],
        ];
    }

    /**
     * Get license status for a domain.
     */
    public function status(string $purchaseCode, string $domain): array
    {
        $license = License::where('purchase_code', $purchaseCode)
            ->with('product')
            ->first();

        if (!$license) {
            return [
                'valid' => false,
                'error' => 'invalid_purchase_code',
            ];
        }

        $activation = Activation::where('license_id', $license->id)
            ->where('domain', $domain)
            ->first();

        return [
            'valid' => $license->isActive(),
            'license_status' => $license->status,
            'license_type' => $license->license_type,
            'activation_status' => $activation?->status,
            'is_activated' => $activation && $activation->isActive(),
            'last_verified_at' => $activation?->last_verified_at?->toIso8601String(),
            'supported_until' => $license->supported_until?->toIso8601String(),
            'has_support' => $license->hasSupportAccess(),
            'product' => [
                'name' => $license->product->name,
                'version' => $license->product->current_version,
            ],
        ];
    }
}
