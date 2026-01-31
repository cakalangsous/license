<?php

namespace App\Jobs;

use App\Models\License;
use App\Models\Product;
use App\Models\Setting;
use App\Notifications\NewSaleNotification;
use App\Services\EnvatoApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProcessEnvatoWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $eventType;
    protected array $payload;

    /**
     * Create a new job instance.
     */
    public function __construct(string $eventType, array $payload)
    {
        $this->eventType = $eventType;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(EnvatoApiService $envatoApi): void
    {
        Log::info('Processing Envato webhook', [
            'event' => $this->eventType,
            'payload' => $this->payload,
        ]);

        match ($this->eventType) {
            'sale' => $this->handleSale($envatoApi),
            'refund' => $this->handleRefund(),
            default => Log::info('Unhandled Envato event type: ' . $this->eventType),
        };
    }

    /**
     * Handle a new sale event
     */
    protected function handleSale(EnvatoApiService $envatoApi): void
    {
        $purchaseCode = $this->payload['purchase_code'] ?? null;
        $itemId = $this->payload['item']['id'] ?? null;

        if (!$purchaseCode) {
            Log::warning('Envato sale webhook missing purchase_code');
            return;
        }

        // Check if license already exists
        if (License::where('purchase_code', $purchaseCode)->exists()) {
            Log::info('License already exists for purchase code: ' . $purchaseCode);
            return;
        }

        // Check if auto-create is enabled
        if (Setting::get('envato_auto_create_license', 'false') !== 'true') {
            Log::info('Auto-create license disabled, skipping');
            return;
        }

        // Find the product by Envato item ID
        $product = Product::where('envato_item_id', $itemId)->first();
        if (!$product) {
            Log::warning('No product found for Envato item ID: ' . $itemId);
            return;
        }

        // Get buyer info from payload or API
        $buyer = $this->payload['buyer'] ?? [];
        $licenseType = strtolower($this->payload['license'] ?? 'regular');
        if (str_contains($licenseType, 'extended')) {
            $licenseType = 'extended';
        } else {
            $licenseType = 'regular';
        }

        // Calculate support period
        $supportMonths = (int) Setting::get('default_support_period_months', '6');
        $purchasedAt = now();
        $supportedUntil = now()->addMonths($supportMonths);

        // Create the license
        $license = License::create([
            'product_id' => $product->id,
            'marketplace_id' => $this->getEnvatoMarketplaceId(),
            'purchase_code' => $purchaseCode,
            'buyer_email' => $buyer['email'] ?? '',
            'buyer_name' => $buyer['name'] ?? '',
            'buyer_username' => $buyer['username'] ?? '',
            'license_type' => $licenseType,
            'status' => 'active',
            'purchased_at' => $purchasedAt,
            'supported_until' => $supportedUntil,
        ]);

        Log::info('License created from Envato webhook', ['license_id' => $license->id]);

        // Send notification if enabled
        if (Setting::get('notify_on_new_sale', 'false') === 'true') {
            $email = Setting::get('notification_email', '');
            if ($email) {
                Notification::route('mail', $email)
                    ->notify(new NewSaleNotification($license));
            }
        }
    }

    /**
     * Handle a refund event
     */
    protected function handleRefund(): void
    {
        $purchaseCode = $this->payload['purchase_code'] ?? null;

        if (!$purchaseCode) {
            Log::warning('Envato refund webhook missing purchase_code');
            return;
        }

        $license = License::where('purchase_code', $purchaseCode)->first();
        if (!$license) {
            Log::info('No license found for refunded purchase code: ' . $purchaseCode);
            return;
        }

        // Revoke the license
        $license->update([
            'status' => 'revoked',
            'notes' => ($license->notes ? $license->notes . "\n" : '') . 'Revoked due to Envato refund on ' . now()->toDateTimeString(),
        ]);

        Log::info('License revoked due to refund', ['license_id' => $license->id]);
    }

    /**
     * Get or create the Envato marketplace ID
     */
    protected function getEnvatoMarketplaceId(): int
    {
        $marketplace = \App\Models\Marketplace::firstOrCreate(
            ['name' => 'Envato'],
            ['is_active' => true]
        );

        return $marketplace->id;
    }
}
