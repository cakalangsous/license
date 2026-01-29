<?php

namespace App\Actions\Core\TwoFactor;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateRecoveryCodes
{
    public function execute(): array
    {
        return Collection::times(8, function () {
            return Str::random(10).'-'.Str::random(10);
        })->all();
    }
}
