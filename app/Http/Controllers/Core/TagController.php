<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Tag\CreateTag;
use App\Actions\Core\Tag\DeleteTag;
use App\Actions\Core\Tag\GetFilteredTags;
use App\Actions\Core\Tag\UpdateTag;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StoreTagRequest;
use App\Http\Requests\Core\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TagController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'posts';
        $this->data['active_menu'] = 'tags';
        $this->data['title'] = 'Tags';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(! auth()->user()->can('tags_view'), 403);

        $this->data['paginatedTags'] = (new GetFilteredTags)->execute($request);

        return inertia('Core/Tags/Index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        (new CreateTag)->execute($request->validated());

        return redirect(route('admin.tags.index'))
            ->with(['success' => true, 'message' => 'New Tag Stored.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        (new UpdateTag)->execute($tag, $request->validated());

        return redirect(route('admin.tags.index'))
            ->with(['success' => true, 'message' => 'Tag Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        abort_if(! auth()->user()->can('tags_delete'), 403);

        (new DeleteTag)->execute($tag);

        return back()->with(['success' => true, 'message' => 'Tag Deleted.']);
    }
}
