<?php

namespace App\Actions\Core\TwoFactor;

use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;

class VerifyTwoFactor
{
    public function execute(User $user, string $code): bool
    {
        if (! $user->two_factor_secret) {
            return false;
        }

        $google2fa = new Google2FA;
        $secret = decrypt($user->two_factor_secret);

        return $google2fa->verifyKey($secret, $code);
    }
}
