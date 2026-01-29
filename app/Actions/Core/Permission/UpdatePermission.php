<?php

namespace App\Actions\Core\Permission;

use Spatie\Permission\Models\Permission;

class UpdatePermission
{
    public function execute(Permission $permission, array $data): Permission
    {
        $permission->update($data);

        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $permission->getChanges()])
            ->log('updated');

        return $permission;
    }
}
