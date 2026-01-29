<?php

namespace App\Actions\Core\TwoFactor;

use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;

class ConfirmTwoFactor
{
    public function execute(User $user, string $secret, string $code): bool
    {
        $google2fa = new Google2FA;

        if ($google2fa->verifyKey($secret, $code)) {
            $generateRecoveryCodes = new GenerateRecoveryCodes;
            $recoveryCodes = $generateRecoveryCodes->execute();

            $user->forceFill([
                'two_factor_secret' => encrypt($secret),
                'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
                'two_factor_confirmed_at' => now(),
            ])->save();

            activity()
                ->performedOn($user)
                ->causedBy($user)
                ->log('enabled_two_factor');

            return true;
        }

        return false;
    }
}
