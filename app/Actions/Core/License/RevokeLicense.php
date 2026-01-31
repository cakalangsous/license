<?php

namespace App\Actions\Core\License;

use App\Models\License;

class RevokeLicense
{
    public function execute(License $license): License
    {
        $license->update(['status' => 'revoked']);

        // Deactivate all activations
        $license->activations()->update(['status' => 'deactivated']);

        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'revoked'])
            ->log('revoked');

        return $license;
    }
}
