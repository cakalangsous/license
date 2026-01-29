<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MediaPermissionInit extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'media_view',
            'media_create', // Upload
            'media_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::findByName('Admin');
        $adminRole->givePermissionTo($permissions);

        $devRole = Role::findByName('Developer');
        $devRole->givePermissionTo($permissions);
    }
}
