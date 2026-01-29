<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Post\CreatePost;
use App\Actions\Core\Post\DeletePost;
use App\Actions\Core\Post\GetFilteredPosts;
use App\Actions\Core\Post\UpdatePost;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StorePostRequest;
use App\Http\Requests\Core\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class PostController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'posts';
        $this->data['active_menu'] = 'posts';
        $this->data['title'] = 'Posts';
    }

    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('posts_view'), 403);

        $this->data['paginatedPosts'] = (new GetFilteredPosts)->execute($request);

        return $this->inertia('Core/Posts/Index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        abort_if(! auth()->user()->can('posts_create'), 403);

        $this->data['active_menu'] = 'post_create';
        $this->data['categories'] = PostCategory::all(['id', 'name']);
        $this->data['tags'] = Tag::all(['id', 'name']);
        $this->data['title'] = 'Create New Post';

        return $this->inertia('Core/Posts/Create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        (new CreatePost)->execute($request->validated(), $request->filepond);

        auth()->user()->notify(new \App\Notifications\SystemNotification('New Post', 'Your post has been successfully created.', null, 'success'));

        return redirect(route('admin.posts.index'))
            ->with(['success' => true, 'message' => 'New post data is saved!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): InertiaResponse
    {
        abort_if(! auth()->user()->can('posts_update'), 403);

        $this->data['categories'] = PostCategory::all(['id', 'name']);
        $this->data['tags'] = Tag::all(['id', 'name']);
        $this->data['post'] = $post->load(['tags' => function ($query) {
            $query->pluck('tag_id');
        }]);

        $temp = $post->tags->toArray();
        $this->data['tags_selected'] = array_map('current', $temp);
        $this->data['title'] = "Edit $post->title data";

        return $this->inertia('Core/Posts/Edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        (new UpdatePost)->execute($post, $request->validated(), $request->image);

        return redirect()->back()
            ->with(['success' => true, 'message' => "Post $post->title data is updated!"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        abort_if(! auth()->user()->can('posts_delete'), 403);

        $title = $post->title;
        (new DeletePost)->execute($post);

        return back()->with(['success' => true, 'message' => "Post \"$title\" deleted successfully!"]);
    }
}
