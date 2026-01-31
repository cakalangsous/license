<?php

namespace App\Actions\Core\BlacklistedDomain;

use App\Models\BlacklistedDomain;

class CreateBlacklistedDomain
{
    public function execute(array $data): BlacklistedDomain
    {
        return BlacklistedDomain::create($data);
    }
}
