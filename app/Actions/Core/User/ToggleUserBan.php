<?php

namespace App\Actions\Core\User;

use App\Models\User;

class ToggleUserBan
{
    public function execute(User $user): User
    {
        $user->is_banned = ! $user->is_banned;
        $user->save();

        return $user;
    }
}
