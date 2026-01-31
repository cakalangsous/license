<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\CoreController;
use App\Models\Activation;
use App\Models\License;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class ActivationController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'activations';
        $this->data['title'] = 'Activations';
    }

    /**
     * Display a listing of all activations.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('activations_view'), 403);

        $query = Activation::with(['license.product', 'license.marketplace']);

        if ($request->search) {
            $query->where('domain', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->is_local !== null) {
            $query->where('is_local', $request->boolean('is_local'));
        }

        $this->data['activations'] = $query->orderBy('activated_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return $this->inertia('Core/Activations/Index', $this->data);
    }

    /**
     * Deactivate an activation.
     */
    public function deactivate(Activation $activation): RedirectResponse
    {
        abort_if(! auth()->user()->can('activations_edit'), 403);

        $activation->deactivate();

        return back()->with(['success' => true, 'message' => 'Activation has been deactivated!']);
    }

    /**
     * Block an activation (suspected piracy).
     */
    public function block(Activation $activation): RedirectResponse
    {
        abort_if(! auth()->user()->can('activations_edit'), 403);

        $activation->block();

        return back()->with(['success' => true, 'message' => 'Activation has been blocked!']);
    }

    /**
     * Reactivate a deactivated activation.
     */
    public function reactivate(Activation $activation): RedirectResponse
    {
        abort_if(! auth()->user()->can('activations_edit'), 403);

        $activation->update(['status' => 'active', 'last_verified_at' => now()]);

        return back()->with(['success' => true, 'message' => 'Activation has been reactivated!']);
    }

    /**
     * Remove an activation entirely.
     */
    public function destroy(Activation $activation): RedirectResponse
    {
        abort_if(! auth()->user()->can('activations_delete'), 403);

        $activation->delete();

        return back()->with(['success' => true, 'message' => 'Activation deleted successfully!']);
    }
}
