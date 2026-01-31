<?php

namespace App\Actions\Core\BlacklistedDomain;

use App\Models\BlacklistedDomain;

class DeleteBlacklistedDomain
{
    public function execute(BlacklistedDomain $domain): bool
    {
        return $domain->delete();
    }
}
