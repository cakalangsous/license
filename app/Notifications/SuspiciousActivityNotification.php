<?php

namespace App\Notifications;

use App\Models\VerificationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspiciousActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $domain;
    protected int $failedCount;
    protected array $recentLogs;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $domain, int $failedCount, array $recentLogs = [])
    {
        $this->domain = $domain;
        $this->failedCount = $failedCount;
        $this->recentLogs = $recentLogs;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('⚠️ Suspicious Activity Detected - ' . $this->domain)
            ->greeting('Security Alert!')
            ->line('Unusual activity has been detected from the following domain:')
            ->line('')
            ->line('**Domain:** ' . $this->domain)
            ->line('**Failed Attempts:** ' . $this->failedCount)
            ->line('');

        if (!empty($this->recentLogs)) {
            $message->line('**Recent Failed Attempts:**');
            foreach (array_slice($this->recentLogs, 0, 5) as $log) {
                $message->line('• ' . $log['created_at'] . ' - ' . $log['action'] . ' (' . ($log['ip_address'] ?? 'unknown IP') . ')');
            }
        }

        return $message
            ->line('')
            ->line('You may want to consider blacklisting this domain.')
            ->action('View Blacklist', url('/admin/blacklisted-domains'))
            ->salutation('— License Management System');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'domain' => $this->domain,
            'failed_count' => $this->failedCount,
        ];
    }
}
