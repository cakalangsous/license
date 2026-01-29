<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\TwoFactor\ConfirmTwoFactor;
use App\Actions\Core\TwoFactor\DisableTwoFactor;
use App\Actions\Core\TwoFactor\EnableTwoFactor;
use App\Actions\Core\TwoFactor\GenerateRecoveryCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    public function enable(EnableTwoFactor $enable)
    {
        $data = $enable->execute(auth()->user());

        return response()->json($data);
    }

    public function confirm(Request $request, ConfirmTwoFactor $confirm)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string',
        ]);

        if ($confirm->execute($request->user(), $request->secret, $request->code)) {
            return back()->with('success', 'Two factor authentication enabled.');
        }

        throw ValidationException::withMessages([
            'code' => 'The provided two factor authentication code was invalid.',
        ]);
    }

    public function disable(Request $request, DisableTwoFactor $disable)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $disable->execute($request->user());

        return back()->with('success', 'Two factor authentication disabled.');
    }

    public function recoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        if (! $request->user()->two_factor_recovery_codes) {
            return response()->json([]);
        }

        return response()->json(json_decode(decrypt($request->user()->two_factor_recovery_codes)));
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $codes = (new GenerateRecoveryCodes)->execute();

        $request->user()->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($codes)),
        ])->save();

        return response()->json($codes);
    }
}
