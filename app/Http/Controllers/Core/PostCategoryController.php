<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\PostCategory\CreateCategory;
use App\Actions\Core\PostCategory\DeleteCategory;
use App\Actions\Core\PostCategory\GetFilteredCategories;
use App\Actions\Core\PostCategory\UpdateCategory;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StorePostCategoryRequest;
use App\Http\Requests\Core\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostCategoryController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'posts';
        $this->data['active_menu'] = 'post_categories';
        $this->data['title'] = 'Post Category';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(! auth()->user()->can('post_categories_view'), 403);

        $this->data['paginatedCategories'] = (new GetFilteredCategories)->execute($request);

        return inertia('Core/PostCategories/Index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostCategoryRequest $request): RedirectResponse
    {
        (new CreateCategory)->execute($request->validated());

        return redirect(route('admin.post_categories.index'))
            ->with(['success' => true, 'message' => 'New Category Stored.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory): RedirectResponse
    {
        (new UpdateCategory)->execute($postCategory, $request->validated());

        return redirect(route('admin.post_categories.index'))
            ->with(['success' => true, 'message' => 'Post Category Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        abort_if(! auth()->user()->can('post_categories_delete'), 403);

        (new DeleteCategory)->execute($postCategory);

        return back()->with(['success' => true, 'message' => 'Post Category Deleted.']);
    }
}
