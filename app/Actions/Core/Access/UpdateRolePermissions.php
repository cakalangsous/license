<?php

namespace App\Actions\Core\Access;

use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;

class UpdateRolePermissions
{
    public function execute(Role $role, array $permissions): Role
    {
        $role->syncPermissions($permissions);

        Artisan::call('optimize:clear');

        return $role;
    }
}
