<?php

namespace App\Actions\Core\Post;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetFilteredPosts
{
    public function execute(Request $request): LengthAwarePaginator
    {
        $query = Post::with(['category', 'tags']);

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Handle sorting
        if ($request->sort) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        $perPage = $request->per_page ?? 10;
        $paginated = $query->paginate($perPage)->withQueryString();

        // Transform the data
        $paginated->getCollection()->transform(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category->name ?? '-',
                'tags' => $post->tags->pluck('name')->implode(', '),
                'publish_status' => $post->publish_status,
                'published_at' => $post->published_at ? date('M j, Y H:i', strtotime($post->published_at)) : '-',
            ];
        });

        return $paginated;
    }
}
