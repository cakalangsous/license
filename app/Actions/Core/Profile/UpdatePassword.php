<?php

namespace App\Actions\Core\Profile;

use App\Models\User;

class UpdatePassword
{
    public function execute(User $user, string $password): User
    {
        $user->update([
            'password' => bcrypt($password),
        ]);

        return $user;
    }
}
