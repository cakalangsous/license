<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\BlacklistedDomain\CreateBlacklistedDomain;
use App\Actions\Core\BlacklistedDomain\DeleteBlacklistedDomain;
use App\Actions\Core\BlacklistedDomain\GetFilteredBlacklistedDomains;
use App\Actions\Core\BlacklistedDomain\UpdateBlacklistedDomain;
use App\Http\Controllers\CoreController;
use App\Models\BlacklistedDomain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class BlacklistedDomainController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'blacklisted_domains';
        $this->data['title'] = 'Blacklisted Domains';
    }

    public function index(Request $request, GetFilteredBlacklistedDomains $action): InertiaResponse
    {
        abort_if(! auth()->user()->can('blacklisted_domains_view'), 403);

        $this->data = array_merge($this->data, $action->execute($request));

        return $this->inertia('Core/BlacklistedDomains/Index', $this->data);
    }

    public function store(Request $request, CreateBlacklistedDomain $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('blacklisted_domains_create'), 403);

        $validated = $request->validate([
            'pattern' => 'required|string|max:255|unique:blacklisted_domains,pattern',
            'reason' => 'nullable|string|max:500',
        ]);

        $action->execute($validated);

        return back()->with(['success' => true, 'message' => 'Domain pattern added to blacklist!']);
    }

    public function update(Request $request, BlacklistedDomain $blacklistedDomain, UpdateBlacklistedDomain $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('blacklisted_domains_edit'), 403);

        $validated = $request->validate([
            'pattern' => 'required|string|max:255|unique:blacklisted_domains,pattern,' . $blacklistedDomain->id,
            'reason' => 'nullable|string|max:500',
        ]);

        $action->execute($blacklistedDomain, $validated);

        return back()->with(['success' => true, 'message' => 'Blacklist entry updated!']);
    }

    public function destroy(BlacklistedDomain $blacklistedDomain, DeleteBlacklistedDomain $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('blacklisted_domains_delete'), 403);

        $action->execute($blacklistedDomain);

        return back()->with(['success' => true, 'message' => 'Domain removed from blacklist!']);
    }

    public function check(Request $request)
    {
        $request->validate(['domain' => 'required|string']);

        $isBlacklisted = BlacklistedDomain::isBlacklisted($request->domain);

        return response()->json([
            'domain' => $request->domain,
            'blacklisted' => $isBlacklisted,
        ]);
    }
}
