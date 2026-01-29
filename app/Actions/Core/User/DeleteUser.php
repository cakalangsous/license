<?php

namespace App\Actions\Core\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DeleteUser
{
    public function execute(User $user): bool
    {
        // Delete avatar if exists
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        // Remove all roles
        foreach ($user->getRoleNames() as $role) {
            $user->removeRole($role);
        }

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $user->toArray()])
            ->log('deleted');

        return $user->delete();
    }
}
