<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LicensePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Products permissions
            ['name' => 'products_view', 'table_name' => 'products'],
            ['name' => 'products_create', 'table_name' => 'products'],
            ['name' => 'products_edit', 'table_name' => 'products'],
            ['name' => 'products_delete', 'table_name' => 'products'],

            // Licenses permissions
            ['name' => 'licenses_view', 'table_name' => 'licenses'],
            ['name' => 'licenses_create', 'table_name' => 'licenses'],
            ['name' => 'licenses_edit', 'table_name' => 'licenses'],
            ['name' => 'licenses_delete', 'table_name' => 'licenses'],

            // Activations permissions
            ['name' => 'activations_view', 'table_name' => 'activations'],
            ['name' => 'activations_edit', 'table_name' => 'activations'],
            ['name' => 'activations_delete', 'table_name' => 'activations'],

            // Sales permissions
            ['name' => 'sales_view', 'table_name' => 'sales'],

            // Marketplaces permissions
            ['name' => 'marketplaces_view', 'table_name' => 'marketplaces'],
            ['name' => 'marketplaces_create', 'table_name' => 'marketplaces'],
            ['name' => 'marketplaces_edit', 'table_name' => 'marketplaces'],
            ['name' => 'marketplaces_delete', 'table_name' => 'marketplaces'],

            // Blacklist permissions
            ['name' => 'blacklisted_domains_view', 'table_name' => 'blacklisted_domains'],
            ['name' => 'blacklisted_domains_create', 'table_name' => 'blacklisted_domains'],
            ['name' => 'blacklisted_domains_edit', 'table_name' => 'blacklisted_domains'],
            ['name' => 'blacklisted_domains_delete', 'table_name' => 'blacklisted_domains'],

            // Verification Logs permissions
            ['name' => 'verification_logs_view', 'table_name' => 'verification_logs'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['table_name' => $permission['table_name']]
            );
        }

        // Assign all new permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $permissionNames = array_column($permissions, 'name');
            $adminRole->givePermissionTo($permissionNames);
        }
    }
}
