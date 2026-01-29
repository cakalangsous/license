<?php

namespace Database\Seeders;

use App\Models\SidebarMenu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ActivityLogInit extends Seeder
{
    public function run()
    {
        Permission::firstOrCreate(['name' => 'activity_log_view']);
        $role = Role::where('name', 'Super Admin')->first();
        if ($role) {
            $role->givePermissionTo('activity_log_view');
        }

        SidebarMenu::firstOrCreate(
            ['route_name' => 'admin.activity-logs.index'],
            [
                'title' => 'Activity Logs',
                'icon' => 'clock',
                'section' => 'System',
                'permission' => 'activity_log_view',
                'order' => 100,
                'is_active' => true,
            ]
        );

        echo "Activity Log initialized.\n";
    }
}
