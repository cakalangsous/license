<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class SupportExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Collection $licenses;
    protected int $days;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collection $licenses, int $days = 30)
    {
        $this->licenses = $licenses;
        $this->days = $days;
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
        $critical = $this->licenses->filter(fn ($l) => $l->supported_until->diffInDays(now()) <= 7);
        $warning = $this->licenses->filter(fn ($l) => $l->supported_until->diffInDays(now()) > 7);

        $message = (new MailMessage)
            ->subject('License Support Expiring Soon - ' . $this->licenses->count() . ' Licenses')
            ->greeting('Hello,')
            ->line('The following licenses have support expiring within ' . $this->days . ' days:');

        if ($critical->isNotEmpty()) {
            $message->line('');
            $message->line('**⚠️ CRITICAL (7 days or less):**');
            foreach ($critical->take(10) as $license) {
                $daysLeft = $license->supported_until->diffInDays(now());
                $message->line('• ' . substr($license->purchase_code, 0, 8) . '... (' . $license->product?->name . ') - ' . $daysLeft . ' days left');
            }
        }

        if ($warning->isNotEmpty()) {
            $message->line('');
            $message->line('**⏰ Expiring Soon:**');
            foreach ($warning->take(10) as $license) {
                $daysLeft = $license->supported_until->diffInDays(now());
                $message->line('• ' . substr($license->purchase_code, 0, 8) . '... (' . $license->product?->name . ') - ' . $daysLeft . ' days left');
            }
        }

        if ($this->licenses->count() > 20) {
            $message->line('');
            $message->line('_...and ' . ($this->licenses->count() - 20) . ' more licenses._');
        }

        return $message
            ->action('View All Licenses', url('/admin/licenses'))
            ->salutation('— License Management System');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'count' => $this->licenses->count(),
            'days' => $this->days,
        ];
    }
}
