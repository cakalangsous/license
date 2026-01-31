<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VerificationLog;
use App\Services\IntegrityService;
use App\Services\LicenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeartbeatController extends Controller
{
    public function __construct(
        protected LicenseService $licenseService,
        protected IntegrityService $integrity
    ) {}

    /**
     * Process heartbeat from an activated domain.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_code' => 'required|string',
            'domain' => 'required|string',
            'app_version' => 'nullable|string',
        ]);

        $result = $this->licenseService->heartbeat(
            $request->purchase_code,
            $request->domain
        );

        VerificationLog::logVerification(
            domain: $request->domain,
            ipAddress: $request->ip(),
            requestType: 'heartbeat',
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
