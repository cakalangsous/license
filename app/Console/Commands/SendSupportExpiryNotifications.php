<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\Setting;
use App\Notifications\SupportExpiringNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendSupportExpiryNotifications extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'license:notify-expiring-support {--days=30 : Days before expiry to check}';

    /**
     * The console command description.
     */
    protected $description = 'Send notifications for licenses with support expiring soon';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        
        // Check if notifications are enabled in settings
        $notifyOn = Setting::get('notify_on_new_sale', 'false') === 'true';
        $email = Setting::get('notification_email', '');
        
        if (!$notifyOn || !$email) {
            $this->info('Notifications are disabled or no email configured.');
            return self::SUCCESS;
        }

        // Get expiring licenses
        $expiringLicenses = License::expiringSupport($days)
            ->with(['product', 'activations'])
            ->get();

        if ($expiringLicenses->isEmpty()) {
            $this->info('No licenses expiring within ' . $days . ' days.');
            return self::SUCCESS;
        }

        // Group by days remaining
        $critical = $expiringLicenses->filter(fn ($l) => $l->supported_until->diffInDays(now()) <= 7);
        $warning = $expiringLicenses->filter(fn ($l) => $l->supported_until->diffInDays(now()) > 7);

        $this->info('Found ' . $expiringLicenses->count() . ' licenses expiring within ' . $days . ' days.');
        $this->info('  - Critical (7 days): ' . $critical->count());
        $this->info('  - Warning: ' . $warning->count());

        // Send notification
        Notification::route('mail', $email)
            ->notify(new SupportExpiringNotification($expiringLicenses, $days));

        $this->info('Notification sent to ' . $email);

        return self::SUCCESS;
    }
}
