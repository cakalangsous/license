<?php

namespace App\Actions\Core\Marketplace;

use App\Models\Marketplace;

class DeleteMarketplace
{
    public function execute(Marketplace $marketplace): bool
    {
        return $marketplace->delete();
    }
}
