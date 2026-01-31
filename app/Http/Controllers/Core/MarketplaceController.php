<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Marketplace\CreateMarketplace;
use App\Actions\Core\Marketplace\DeleteMarketplace;
use App\Actions\Core\Marketplace\GetFilteredMarketplaces;
use App\Actions\Core\Marketplace\UpdateMarketplace;
use App\Http\Controllers\CoreController;
use App\Models\Marketplace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class MarketplaceController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'marketplaces';
        $this->data['title'] = 'Marketplaces';
    }

    public function index(Request $request, GetFilteredMarketplaces $action): InertiaResponse
    {
        abort_if(! auth()->user()->can('marketplaces_view'), 403);

        $this->data = array_merge($this->data, $action->execute($request));

        return $this->inertia('Core/Marketplaces/Index', $this->data);
    }

    public function store(Request $request, CreateMarketplace $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('marketplaces_create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:marketplaces,slug',
            'api_token' => 'nullable|string',
            'api_base_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ]);

        $action->execute($validated);

        return back()->with(['success' => true, 'message' => 'Marketplace created successfully!']);
    }

    public function update(Request $request, Marketplace $marketplace, UpdateMarketplace $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('marketplaces_edit'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:marketplaces,slug,' . $marketplace->id,
            'api_token' => 'nullable|string',
            'api_base_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ]);

        $action->execute($marketplace, $validated);

        return back()->with(['success' => true, 'message' => 'Marketplace updated successfully!']);
    }

    public function destroy(Marketplace $marketplace, DeleteMarketplace $action): RedirectResponse
    {
        abort_if(! auth()->user()->can('marketplaces_delete'), 403);

        $name = $marketplace->name;
        $action->execute($marketplace);

        return back()->with(['success' => true, 'message' => 'Marketplace "' . $name . '" deleted successfully!']);
    }
}
