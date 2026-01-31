<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VerificationLog;
use App\Services\IntegrityService;
use App\Services\LicenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function __construct(
        protected LicenseService $licenseService,
        protected IntegrityService $integrity
    ) {}

    /**
     * Activate a license on a domain.
     */
    public function activate(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_code' => 'required|string',
            'domain' => 'required|string',
            'is_local' => 'boolean',
            'app_version' => 'nullable|string',
            'php_version' => 'nullable|string',
            'laravel_version' => 'nullable|string',
        ]);

        $result = $this->licenseService->activate(
            purchaseCode: $request->purchase_code,
            domain: $request->domain,
            isLocal: $request->boolean('is_local', false),
            appVersion: $request->app_version,
            phpVersion: $request->php_version,
            laravelVersion: $request->laravel_version,
            serverIp: $request->ip()
        );

        VerificationLog::logVerification(
            domain: $request->domain,
            ipAddress: $request->ip(),
            requestType: 'activate',
            status: $result['valid'] ? 'success' : 'failed',
            activationId: $result['activation_id'] ?? null,
            failureReason: $result['error'] ?? null,
            requestData: [
                'is_local' => $request->boolean('is_local'),
                'app_version' => $request->app_version,
            ],
            appName: $request->header('X-App-Name') ?? $request->app_name,
        );

        return response()->json(
            $this->integrity->seal($result),
            $result['valid'] ? 200 : 400
        );
    }

    /**
     * Deactivate a license from a domain.
     */
    public function deactivate(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_code' => 'required|string',
            'domain' => 'required|string',
        ]);

        $result = $this->licenseService->deactivate(
            $request->purchase_code,
            $request->domain
        );

        VerificationLog::logVerification(
            domain: $request->domain,
            ipAddress: $request->ip(),
            requestType: 'deactivate',
            status: $result['valid'] ? 'success' : 'failed',
            failureReason: $result['error'] ?? null,
            appName: $request->header('X-App-Name'),
        );

        return response()->json(
            $this->integrity->seal($result),
            $result['valid'] ? 200 : 400
        );
    }
}
