<?php

namespace App\Notifications;

use App\Models\License;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected License $license;

    /**
     * Create a new notification instance.
     */
    public function __construct(License $license)
    {
        $this->license = $license;
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
        return (new MailMessage)
            ->subject('🎉 New Sale - ' . ($this->license->product?->name ?? 'Product'))
            ->greeting('Congratulations!')
            ->line('You have a new sale!')
            ->line('')
            ->line('**Product:** ' . ($this->license->product?->name ?? 'Unknown'))
            ->line('**License Type:** ' . ucfirst($this->license->license_type))
            ->line('**Buyer:** ' . ($this->license->buyer_email ?: $this->license->buyer_username ?: 'Unknown'))
            ->line('**Purchase Code:** ' . substr($this->license->purchase_code, 0, 8) . '...')
            ->line('')
            ->action('View License', url('/admin/licenses/' . $this->license->id))
            ->salutation('— License Management System');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'license_id' => $this->license->id,
            'product' => $this->license->product?->name,
            'buyer' => $this->license->buyer_email,
        ];
    }
}
