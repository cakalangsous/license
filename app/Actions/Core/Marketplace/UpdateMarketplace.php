<?php

namespace App\Actions\Core\Marketplace;

use App\Models\Marketplace;
use Illuminate\Support\Str;

class UpdateMarketplace
{
    public function execute(Marketplace $marketplace, array $data): Marketplace
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $marketplace->update($data);

        return $marketplace;
    }
}
