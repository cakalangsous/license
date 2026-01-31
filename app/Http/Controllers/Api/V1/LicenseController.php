<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VerificationLog;
use App\Services\IntegrityService;
use App\Services\LicenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function __construct(
        protected LicenseService $licenseService,
        protected IntegrityService $integrity
    ) {}

    /**
     * Verify a purchase code.
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_code' => 'required|string',
        ]);

        $result = $this->licenseService->verify($request->purchase_code);

        VerificationLog::logVerification(
            domain: $request->header('X-Domain', $request->ip()),
            ipAddress: $request->ip(),
            requestType: 'verify',
            status: $result['valid'] ? 'success' : 'failed',
            failureReason: $result['error'] ?? null,
            appName: $request->header('X-App-Name'),
        );

        return response()->json(
            $this->integrity->seal($result),
            $result['valid'] ? 200 : 400
        );
    }

    /**
     * Get license status for a domain.
     */
    public function status(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_code' => 'required|string',
            'domain' => 'required|string',
        ]);

        $result = $this->licenseService->status(
            $request->purchase_code,
            $request->domain
        );

        return response()->json($this->integrity->seal($result));
    }
}
