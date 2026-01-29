<?php

namespace App\Actions\Core\Tag;

use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetFilteredTags
{
    public function execute(Request $request): LengthAwarePaginator
    {
        $query = Tag::orderBy('id', 'desc');

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Handle sorting
        if ($request->sort) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->reorder($request->sort, $direction);
        }

        $perPage = $request->per_page ?? 10;

        return $query->paginate($perPage)->withQueryString();
    }
}
