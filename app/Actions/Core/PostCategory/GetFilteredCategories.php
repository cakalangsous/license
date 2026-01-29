<?php

namespace App\Actions\Core\PostCategory;

use App\Models\PostCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetFilteredCategories
{
    public function execute(Request $request): LengthAwarePaginator
    {
        $query = PostCategory::orderBy('id', 'desc');

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
