<?php

namespace App\Actions\Core\License;

use App\Models\License;

class UpdateLicense
{
    public function execute(License $license, array $data): License
    {
        $old = $license->toArray();

        $license->update($data);

        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $old,
                'attributes' => $license->fresh()->toArray(),
            ])
            ->log('updated');

        return $license;
    }
}
