<?php

namespace App\Actions\Core\BlacklistedDomain;

use App\Models\BlacklistedDomain;

class UpdateBlacklistedDomain
{
    public function execute(BlacklistedDomain $domain, array $data): BlacklistedDomain
    {
        $domain->update($data);
        return $domain;
    }
}
