<?php

namespace App\Actions\Core\Settings;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Exception;

class SendTestEmail
{
    /**
     * Send a test email using current mail configuration.
     *
     * @param string $toEmail Email address to send test to
     * @return array{success: bool, message: string}
     */
    public function execute(string $toEmail): array
    {
        try {
            $appName = config('app.name', 'Laraku');
            $fromAddress = config('mail.from.address');
            $fromName = config('mail.from.name');

            Mail::raw(
                "This is a test email from {$appName}.\n\nIf you received this email, your SMTP configuration is working correctly.\n\nSent at: " . now()->format('Y-m-d H:i:s'),
                function (Message $message) use ($toEmail, $appName, $fromAddress, $fromName) {
                    $message->to($toEmail)
                        ->subject("{$appName} - Test Email")
                        ->from($fromAddress, $fromName);
                }
            );

            return [
                'success' => true,
                'message' => "Test email sent successfully to {$toEmail}",
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage(),
            ];
        }
    }
}
