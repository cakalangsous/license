<?php

namespace App\Http\Controllers\Core\Auth;

use App\Actions\Core\TwoFactor\VerifyTwoFactor;
use App\Http\Controllers\CoreController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class TwoFactorChallengeController extends CoreController
{
    public function create(Request $request): Response
    {
        if (! $request->session()->has('login.id')) {
            abort(404);
        }

        return $this->inertia('Core/Auth/TwoFactorChallenge');
    }

    public function store(Request $request, VerifyTwoFactor $verify)
    {
        $validated = $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $userId = $request->session()->get('login.id');
        $user = User::findOrFail($userId);

        if ($request->filled('recovery_code')) {
            $this->verifyRecoveryCode($user, $request->recovery_code);
        } elseif (! $verify->execute($user, $request->code)) {
            throw ValidationException::withMessages([
                'code' => ['The provided two factor authentication code was invalid.'],
            ]);
        }

        Auth::login($user, $request->session()->get('login.remember', false));
        $request->session()->regenerate();
        $request->session()->forget(['login.id', 'login.remember']);

        return redirect()->intended(route('admin.dashboard'));
    }

    protected function verifyRecoveryCode(User $user, string $code)
    {
        if (! $user->two_factor_recovery_codes) {
            throw ValidationException::withMessages([
                'recovery_code' => ['The provided recovery code was invalid.'],
            ]);
        }

        $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        if (($key = array_search($code, $codes)) !== false) {
            unset($codes[$key]);

            $user->forceFill([
                'two_factor_recovery_codes' => encrypt(json_encode(array_values($codes))),
            ])->save();

            return true;
        }

        throw ValidationException::withMessages([
            'recovery_code' => ['The provided recovery code was invalid.'],
        ]);
    }
}
