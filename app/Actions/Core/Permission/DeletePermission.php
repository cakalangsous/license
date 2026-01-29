<?php

namespace App\Actions\Core\Permission;

use Spatie\Permission\Models\Permission;

class DeletePermission
{
    public function execute(Permission $permission): bool
    {
        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $permission->toArray()])
            ->log('deleted');

        return $permission->delete();
    }
}
