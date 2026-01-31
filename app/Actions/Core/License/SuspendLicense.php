<?php

namespace App\Actions\Core\License;

use App\Models\License;

class SuspendLicense
{
    public function execute(License $license): License
    {
        $license->update(['status' => 'suspended']);

        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'suspended'])
            ->log('suspended');

        return $license;
    }
}
