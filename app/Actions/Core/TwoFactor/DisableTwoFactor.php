<?php

namespace App\Actions\Core\TwoFactor;

use App\Models\User;

class DisableTwoFactor
{
    public function execute(User $user): void
    {
        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('disabled_two_factor');
    }
}
