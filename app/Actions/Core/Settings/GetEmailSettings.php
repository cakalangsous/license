<?php

namespace App\Actions\Core\Settings;

class GetEmailSettings
{
    /**
     * Get email settings from environment file.
     */
    public function execute(): array
    {
        return [
            'mail_mailer' => env('MAIL_MAILER', 'log'),
            'mail_host' => env('MAIL_HOST', '127.0.0.1'),
            'mail_port' => env('MAIL_PORT', 2525),
            'mail_username' => env('MAIL_USERNAME', ''),
            'mail_password' => env('MAIL_PASSWORD', ''),
            'mail_encryption' => env('MAIL_ENCRYPTION', ''),
            'mail_from_address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'mail_from_name' => env('MAIL_FROM_NAME', config('app.name')),
        ];
    }
}
