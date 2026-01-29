<?php

namespace App\Actions\Core\ApiToken;

use App\Models\User;
use Illuminate\Support\Collection;

class GetUserTokens
{
    public function execute(User $user): Collection
    {
        return $user->tokens()
            ->orderBy('last_used_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'last_used_at' => $token->last_used_at?->diffForHumans() ?? 'Never',
                    'created_at' => $token->created_at->diffForHumans(),
                    'abilities' => $token->abilities,
                ];
            });
    }
}
