<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\License\CreateLicense;
use App\Actions\Core\License\DeleteLicense;
use App\Actions\Core\License\GetFilteredLicenses;
use App\Actions\Core\License\ReactivateLicense;
use App\Actions\Core\License\RevokeLicense;
use App\Actions\Core\License\SuspendLicense;
use App\Actions\Core\License\UpdateLicense;
use App\Http\Controllers\CoreController;
use App\Models\License;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class LicenseController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'licenses';
        $this->data['title'] = 'Licenses';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetFilteredLicenses $action): InertiaResponse
    {
        abort_if(! auth()->user()->can('licenses_view'), 403);

        $this->data = array_merge($this->data, $action->execute($request));

        return $this->inertia('Core/Licenses/Index', $this->data);
    }

    /**
     * Display license details with activations.
     */
    public function show(License $license): InertiaResponse
    {
        abort_if(! auth()->user()->can('licenses_view'), 403);

        $this->data['license'] = $license->load([
            'product',
            'marketplace',
            'activations' => fn($q) => $q->orderBy('activated_at', 'desc'),
            'verificationLogs' => fn($q) => $q->latest('created_at')->limit(50),
        ]);

        // Activation statistics
        $this->data['stats'] = [
            'local_activations' => $license->getLocalActivationCount(),
            'production_activations' => $license->getUsedDomainCount(),
            'total_activations' => $license->activeActivations()->count(),
            'domain_limit' => $license->getDomainLimit(),
        ];

        return $this->inertia('Core/Licenses/Show', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_create'), 403);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'marketplace_id' => 'required|exists:marketplaces,id',
            'purchase_code' => 'required|string|max:255|unique:licenses,purchase_code',
            'buyer_email' => 'required|email|max:255',
            'buyer_name' => 'nullable|string|max:255',
            'buyer_username' => 'nullable|string|max:255',
            'license_type' => 'required|in:regular,extended',
            'purchased_at' => 'required|date',
            'supported_until' => 'nullable|date',
            'status' => 'required|in:active,suspended,revoked,expired',
            'notes' => 'nullable|string',
        ]);

        $action->execute($validated);

        return back()->with(['success' => true, 'message' => 'License created successfully!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, License $license, UpdateLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_edit'), 403);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'marketplace_id' => 'required|exists:marketplaces,id',
            'purchase_code' => 'required|string|max:255|unique:licenses,purchase_code,' . $license->id,
            'buyer_email' => 'required|email|max:255',
            'buyer_name' => 'nullable|string|max:255',
            'buyer_username' => 'nullable|string|max:255',
            'license_type' => 'required|in:regular,extended',
            'purchased_at' => 'required|date',
            'supported_until' => 'nullable|date',
            'status' => 'required|in:active,suspended,revoked,expired',
            'notes' => 'nullable|string',
        ]);

        $action->execute($license, $validated);

        return back()->with(['success' => true, 'message' => 'License updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(License $license, DeleteLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_delete'), 403);

        $action->execute($license);

        return back()->with(['success' => true, 'message' => 'License deleted successfully!']);
    }

    /**
     * Revoke a license.
     */
    public function revoke(License $license, RevokeLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_edit'), 403);

        $action->execute($license);

        return back()->with(['success' => true, 'message' => 'License has been revoked!']);
    }

    /**
     * Suspend a license.
     */
    public function suspend(License $license, SuspendLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_edit'), 403);

        $action->execute($license);

        return back()->with(['success' => true, 'message' => 'License has been suspended!']);
    }

    /**
     * Reactivate a license.
     */
    public function reactivate(License $license, ReactivateLicense $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('licenses_edit'), 403);

        $action->execute($license);

        return back()->with(['success' => true, 'message' => 'License has been reactivated!']);
    }
}
