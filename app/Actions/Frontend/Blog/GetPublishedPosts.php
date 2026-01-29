<?php

namespace App\Actions\Frontend\Blog;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPublishedPosts
{
    public function execute(int $perPage = 9): LengthAwarePaginator
    {
        return Post::query()
            ->where('publish_status', 1)
            ->with(['category:id,name'])
            ->select([
                'id',
                'title',
                'slug',
                'image',
                'excerpt',
                'post_category_id',
                'published_at',
                'created_at',
            ])
            ->orderBy('published_at', 'desc')
            ->paginate($perPage)
            ->through(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'image' => $post->image ? (str_starts_with($post->image, '/') || str_starts_with($post->image, 'http') ? $post->image : '/storage/' . $post->image) : null,
                'excerpt' => $post->excerpt,
                'category' => $post->category?->name ?? 'Uncategorized',
                'published_at' => $post->getRawOriginal('published_at') 
                    ? Carbon::parse($post->getRawOriginal('published_at'))->format('M d, Y') 
                    : null,
            ]);
    }
}
