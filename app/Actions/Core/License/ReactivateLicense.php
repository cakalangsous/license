<?php

namespace App\Actions\Core\License;

use App\Models\License;

class ReactivateLicense
{
    public function execute(License $license): License
    {
        $license->update(['status' => 'active']);

        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'reactivated'])
            ->log('reactivated');

        return $license;
    }
}
