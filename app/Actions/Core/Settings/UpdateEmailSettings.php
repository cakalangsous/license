<?php

namespace App\Actions\Core\Settings;

use Illuminate\Support\Facades\File;

class UpdateEmailSettings
{
    /**
     * Update email settings in the .env file.
     */
    public function execute(array $data): void
    {
        $envPath = base_path('.env');

        if (! File::exists($envPath)) {
            return;
        }

        $envContent = File::get($envPath);

        $mappings = [
            'mail_mailer' => 'MAIL_MAILER',
            'mail_host' => 'MAIL_HOST',
            'mail_port' => 'MAIL_PORT',
            'mail_username' => 'MAIL_USERNAME',
            'mail_password' => 'MAIL_PASSWORD',
            'mail_encryption' => 'MAIL_ENCRYPTION',
            'mail_from_address' => 'MAIL_FROM_ADDRESS',
            'mail_from_name' => 'MAIL_FROM_NAME',
        ];

        foreach ($mappings as $formKey => $envKey) {
            if (array_key_exists($formKey, $data)) {
                $envContent = $this->setEnvValue($envContent, $envKey, $data[$formKey]);
            }
        }

        File::put($envPath, $envContent);

        // Clear config cache to reflect changes
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
    }

    /**
     * Set or update an environment variable in the .env content.
     */
    private function setEnvValue(string $envContent, string $key, ?string $value): string
    {
        $value = $value ?? '';

        // Quote the value if it contains spaces or special characters
        $escapedValue = $this->formatEnvValue($value);

        // Check if the key already exists
        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $envContent)) {
            // Replace existing value
            return preg_replace($pattern, "{$key}={$escapedValue}", $envContent);
        }

        // Add new key-value pair at the end
        return $envContent."\n{$key}={$escapedValue}";
    }

    /**
     * Format the value for .env file (add quotes if necessary).
     */
    private function formatEnvValue(string $value): string
    {
        // If empty, return as-is
        if ($value === '' || $value === 'null') {
            return $value === '' ? '' : 'null';
        }

        // If contains spaces, quotes, or special characters, wrap in quotes
        if (preg_match('/[\s"\'#]/', $value) || str_contains($value, '${')) {
            // Escape any existing double quotes and wrap in double quotes
            return '"'.str_replace('"', '\\"', $value).'"';
        }

        return $value;
    }
}
