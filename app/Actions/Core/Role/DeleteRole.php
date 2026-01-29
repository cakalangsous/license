<?php

namespace App\Actions\Core\Role;

use Spatie\Permission\Models\Role;

class DeleteRole
{
    public function execute(Role $role): bool
    {
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $role->toArray()])
            ->log('deleted');

        return $role->delete();
    }
}
