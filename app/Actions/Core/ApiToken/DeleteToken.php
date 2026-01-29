<?php

namespace App\Actions\Core\ApiToken;

use App\Models\User;

class DeleteToken
{
    public function execute(User $user, int $tokenId): bool
    {
        return $user->tokens()->where('id', $tokenId)->delete() > 0;
    }
}
