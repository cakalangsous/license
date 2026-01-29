<?php

namespace App\Actions\Core\Permission;

use Spatie\Permission\Models\Permission;

class CreatePermission
{
    public function execute(array $data): Permission
    {
        $permission = Permission::create($data);

        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $permission->toArray()])
            ->log('created');

        return $permission;
    }
}
