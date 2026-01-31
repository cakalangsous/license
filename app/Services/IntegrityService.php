<?php

namespace App\Services;

/**
 * Response signing service for API authentication.
 * Uses HMAC symmetric cryptography for simplicity.
 */
class IntegrityService
{
    protected ?string $secretKey;

    public function __construct()
    {
        $this->secretKey = config('app.signing_key');

        if (empty($this->secretKey)) {
            throw new \RuntimeException('Signing key not configured. Please set SIGNING_KEY in your .env file (any random string, at least 32 characters).');
        }
    }

    /**
     * Sign data and return with HMAC signature.
     */
    public function seal(array $data): array
    {
        $payload = json_encode($data, JSON_UNESCAPED_SLASHES);
        
        $signature = hash_hmac('sha256', $payload, $this->secretKey);

        return [
            'd' => $data,
            's' => $signature,
        ];
    }

    /**
     * Verify a signed response.
     */
    public function verify(array $response): bool
    {
        if (!isset($response['d']) || !isset($response['s'])) {
            return false;
        }

        $payload = json_encode($response['d'], JSON_UNESCAPED_SLASHES);
        $expectedSignature = hash_hmac('sha256', $payload, $this->secretKey);

        return hash_equals($expectedSignature, $response['s']);
    }

    /**
     * Generate a random secret key for initial setup.
     */
    public static function generateKey(): string
    {
        return bin2hex(random_bytes(32));
    }
}
