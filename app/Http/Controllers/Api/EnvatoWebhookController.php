<?php

namespace App\Http\Controllers\Api;

use App\Jobs\ProcessEnvatoWebhook;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnvatoWebhookController
{
    /**
     * Handle incoming Envato webhook
     */
    public function handle(Request $request): JsonResponse
    {
        // Check if webhooks are enabled
        if (Setting::get('envato_webhook_enabled', 'false') !== 'true') {
            return response()->json(['message' => 'Webhooks disabled'], 403);
        }

        // Verify webhook signature
        $secret = Setting::get('envato_webhook_secret', '');
        if (!$this->verifySignature($request, $secret)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payload = $request->all();
        $eventType = $request->header('X-Envato-Event', $payload['event'] ?? 'unknown');

        // Dispatch job to process webhook asynchronously
        ProcessEnvatoWebhook::dispatch($eventType, $payload);

        return response()->json(['message' => 'Webhook received'], 200);
    }

    /**
     * Verify Envato webhook signature
     */
    protected function verifySignature(Request $request, string $secret): bool
    {
        if (empty($secret)) {
            return true; // Skip validation if no secret configured
        }

        $signature = $request->header('X-Envato-Signature');
        if (!$signature) {
            return false;
        }

        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
