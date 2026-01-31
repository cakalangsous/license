<?php

namespace App\Actions\Core\License;

use App\Models\License;

class DeleteLicense
{
    public function execute(License $license): bool
    {
        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $license->toArray()])
            ->log('deleted');

        return $license->delete();
    }
}
