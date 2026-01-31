<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnvatoApiService
{
    protected string $baseUrl = 'https://api.envato.com/v3/market';
    protected ?string $token = null;

    public function __construct()
    {
        $this->token = Setting::get('envato_personal_token', '');
    }

    /**
     * Get author's sale by purchase code
     */
    public function verifySale(string $purchaseCode): ?array
    {
        if (empty($this->token)) {
            Log::warning('Envato API token not configured');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/author/sale', [
                'code' => $purchaseCode,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->status() === 404) {
                return null; // Not found or not author's sale
            }

            Log::warning('Envato API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Envato API exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Get buyer purchase info
     */
    public function getBuyerPurchase(string $purchaseCode): ?array
    {
        $sale = $this->verifySale($purchaseCode);
        
        if (!$sale) {
            return null;
        }

        return [
            'purchase_code' => $sale['code'] ?? $purchaseCode,
            'item_id' => $sale['item']['id'] ?? null,
            'item_name' => $sale['item']['name'] ?? null,
            'buyer_username' => $sale['buyer'] ?? null,
            'license_type' => $sale['license'] ?? 'Regular',
            'purchase_count' => $sale['purchase_count'] ?? 1,
            'sold_at' => $sale['sold_at'] ?? null,
            'supported_until' => $sale['supported_until'] ?? null,
            'amount' => $sale['amount'] ?? null,
        ];
    }

    /**
     * Check if token is configured and valid
     */
    public function isConfigured(): bool
    {
        return !empty($this->token);
    }
}
