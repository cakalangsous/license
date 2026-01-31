<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\CoreController;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use Illuminate\Support\Str;

class ProductController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'license';
        $this->data['active_menu'] = 'products';
        $this->data['title'] = 'Products';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('products_view'), 403);

        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $this->data['products'] = $query->withCount('licenses')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return $this->inertia('Core/Products/Index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('products_create'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'current_version' => 'required|string|max:50',
            'envato_item_id' => 'nullable|string|max:50',
            'regular_domain_limit' => 'required|integer|min:1',
            'extended_domain_limit' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['encryption_salt'] = Str::random(32);

        Product::create($validated);

        return back()->with(['success' => true, 'message' => 'Product created successfully!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_if(! auth()->user()->can('products_edit'), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'current_version' => 'required|string|max:50',
            'envato_item_id' => 'nullable|string|max:50',
            'regular_domain_limit' => 'required|integer|min:1',
            'extended_domain_limit' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        return back()->with(['success' => true, 'message' => 'Product updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        abort_if(! auth()->user()->can('products_delete'), 403);

        $name = $product->name;
        $product->delete();

        return back()->with(['success' => true, 'message' => 'Product "' . $name . '" deleted successfully!']);
    }
}
