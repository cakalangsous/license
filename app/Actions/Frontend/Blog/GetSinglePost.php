<?php

namespace App\Actions\Frontend\Blog;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetSinglePost
{
    public function execute(string $slug): array
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->where('publish_status', 1)
            ->with(['category:id,name', 'tags:id,name'])
            ->firstOrFail();

        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'image' => $post->image ? (str_starts_with($post->image, '/') || str_starts_with($post->image, 'http') ? $post->image : '/storage/' . $post->image) : null,
            'body' => $post->body,
            'excerpt' => $post->excerpt,
            'meta_description' => $post->meta_description,
            'meta_keywords' => $post->meta_keywords,
            'category' => $post->category?->name ?? 'Uncategorized',
            'tags' => $post->tags->pluck('name')->toArray(),
            'published_at' => $post->getRawOriginal('published_at') 
                ? Carbon::parse($post->getRawOriginal('published_at'))->format('M d, Y') 
                : null,
            'created_at' => $post->created_at->format('M d, Y'),
        ];
    }
}
