<?php

namespace App\Actions\Core\Role;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class GetFilteredRoles
{
    public function execute(Request $request): LengthAwarePaginator
    {
        $query = Role::where('id', '>', 1)->where('name', '!=', 'Developer');

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Handle sorting
        if ($request->sort) {
            $direction = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        $perPage = $request->per_page ?? 10;

        return $query->paginate($perPage)->withQueryString();
    }
}
