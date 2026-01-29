<?php

namespace App\Actions\Core\Role;

use Spatie\Permission\Models\Role;

class CreateRole
{
    public function execute(array $data): Role
    {
        $role = Role::create($data);

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $role->toArray()])
            ->log('created');

        return $role;
    }
}
