<?php

namespace App\Actions\Core\License;

use App\Models\License;
use Illuminate\Support\Str;

class CreateLicense
{
    public function execute(array $data): License
    {
        $data['uuid'] = Str::uuid()->toString();

        $license = License::create($data);

        activity()
            ->performedOn($license)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $license->toArray()])
            ->log('created');

        return $license;
    }
}
