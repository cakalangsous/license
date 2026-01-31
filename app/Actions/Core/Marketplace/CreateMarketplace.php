<?php

namespace App\Actions\Core\Marketplace;

use App\Models\Marketplace;
use Illuminate\Support\Str;

class CreateMarketplace
{
    public function execute(array $data): Marketplace
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return Marketplace::create($data);
    }
}
