<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\LicenseController;
use App\Http\Controllers\Api\V1\ActivationController;
use App\Http\Controllers\Api\V1\HeartbeatController;

/*
|--------------------------------------------------------------------------
| License API Routes (Public - Rate Limited)
|--------------------------------------------------------------------------
| Verify/Status: 30/min (read-only checks)  
| Activate/Deactivate: 10/min (destructive actions)
| Heartbeat: 60/min (frequent, lightweight)
*/
Route::prefix('v1/license')->group(function () {
    // Read-only verification routes
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('/verify', [LicenseController::class, 'verify']);
        Route::post('/status', [LicenseController::class, 'status']);
    });

    // Activation routes (stricter limits)
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/activate', [ActivationController::class, 'activate']);
        Route::post('/deactivate', [ActivationController::class, 'deactivate']);
    });

    // Heartbeat (higher limit)
    Route::post('/heartbeat', HeartbeatController::class)->middleware('throttle:60,1');
});

/*
|--------------------------------------------------------------------------
| Authenticated API Routes
|--------------------------------------------------------------------------
*/
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| Envato Webhook
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/envato', [\App\Http\Controllers\Api\EnvatoWebhookController::class, 'handle'])
    ->name('webhooks.envato');

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    require __DIR__.'/api_crud.php';
});
