<?php

namespace App\Actions\Core\Role;

use Spatie\Permission\Models\Role;

class UpdateRole
{
    public function execute(Role $role, array $data): Role
    {
        $role->name = $data['name'];
        $role->save();

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $role->getChanges()])
            ->log('updated');

        return $role;
    }
}
