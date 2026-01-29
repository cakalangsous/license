<?php

namespace App\Actions\Core\Access;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GetAccessMatrix
{
    public function execute(Request $request): array
    {
        $roles = Role::where('id', '>', 1)->orderBy('id')->get();
        $selectedRoleId = $request->query('role_id', $roles->first()?->id);
        $activeRole = Role::with('permissions')->find($selectedRoleId);

        if (! $activeRole && $roles->isNotEmpty()) {
            $activeRole = $roles->first();
        }

        $allPerms = Permission::all();
        $groupPermsGrouping = [];

        foreach ($allPerms as $perm) {
            $groupName = 'others';
            $permTmpArr = explode('_', $perm->name);

            if (isset($permTmpArr[0]) && ! empty($permTmpArr[0])) {
                $groupName = strtolower($permTmpArr[0]);
            }

            if ($perm->table_name != null) {
                $groupName = strtolower($perm->table_name);
            }

            $groupPermsGrouping[$groupName][] = $perm;
        }

        // Sort groups alphabetically
        ksort($groupPermsGrouping);

        return [
            'roles' => $roles,
            'active_role' => $activeRole,
            'permissions' => $groupPermsGrouping,
        ];
    }
}
