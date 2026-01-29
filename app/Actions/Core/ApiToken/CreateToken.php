<?php

namespace App\Actions\Core\ApiToken;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class CreateToken
{
    public function execute(User $user, string $name, array $permissions = ['*']): NewAccessToken
    {
        return $user->createToken($name, $permissions);
    }
}
