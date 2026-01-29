<?php

namespace App\Actions\Core\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetFilteredUsers
{
    public function execute(Request $request): LengthAwarePaginator
    {
        $query = User::with('roles')
            ->where('id', '!=', 1)
            ->where('email', '!=', 'developer@dev.com');

        // Handle search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
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

        // Transform the data to include computed fields
        $paginated->getCollection()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->roles->pluck('name')->implode(', '),
                'last_login' => $user->last_login ? date('M j, Y H:i', strtotime($user->last_login)) : '-',
                'is_banned' => $user->is_banned,
            ];
        });

        return $paginated;
    }
}
