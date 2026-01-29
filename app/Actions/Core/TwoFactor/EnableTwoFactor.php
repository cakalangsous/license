<?php

namespace App\Actions\Core\TwoFactor;

use App\Models\User;
use PragmaRX\Google2FAQRCode\Google2FA;

class EnableTwoFactor
{
    public function execute(User $user): array
    {
        $google2fa = new Google2FA;
        $secret = $google2fa->generateSecretKey();

        $qrCode = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return [
            'secret' => $secret,
            'qr_code' => $qrCode,
        ];
    }
}
