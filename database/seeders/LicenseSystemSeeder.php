<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Marketplace;
use App\Models\BlacklistedDomain;
use Illuminate\Database\Seeder;

class LicenseSystemSeeder extends Seeder
{
    public function run(): void
    {
        // Create default product (Laraku)
        Product::firstOrCreate(
            ['slug' => 'laraku'],
            [
                'name' => 'Laraku',
                'description' => 'Admin panel + CRUD Builder for Laravel developers',
                'current_version' => '1.0.0',
                'regular_domain_limit' => 1,
                'extended_domain_limit' => 5,
                'is_active' => true,
            ]
        );

        // Create default marketplace (CodeCanyon)
        Marketplace::firstOrCreate(
            ['slug' => 'codecanyon'],
            [
                'name' => 'CodeCanyon',
                'api_base_url' => 'https://api.envato.com',
                'is_active' => true,
            ]
        );

        // Create default blacklisted domain patterns
        $blacklistPatterns = [
            ['pattern' => '*.nulled.*', 'reason' => 'Known nulled scripts site'],
            ['pattern' => '*.warez.*', 'reason' => 'Known warez site'],
            ['pattern' => 'nulled.to', 'reason' => 'Known nulled scripts forum'],
            ['pattern' => 'nulled.cc', 'reason' => 'Known nulled scripts forum'],
            ['pattern' => '*.cracked.*', 'reason' => 'Known cracked software site'],
        ];

        foreach ($blacklistPatterns as $pattern) {
            BlacklistedDomain::firstOrCreate(
                ['pattern' => $pattern['pattern']],
                ['reason' => $pattern['reason']]
            );
        }
    }
}
