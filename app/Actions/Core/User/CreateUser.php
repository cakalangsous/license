<?php

namespace App\Actions\Core\User;

use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CreateUser
{
    public function execute(array $data, ?string $filepondFolder = null): User
    {
        // Handle avatar upload
        if ($filepondFolder) {
            $temp = TemporaryFile::where('folder', $filepondFolder)->first();

            if ($temp) {
                $realpath = 'admin/'.$temp->filename;
                Storage::copy('temp/'.$temp->folder.'/'.$temp->filename, 'public/'.$realpath);
                $data['avatar'] = $realpath;

                // Clean up temp file
                Storage::deleteDirectory('temp/'.$temp->folder);
                $temp->delete();
            }
        }

        // Hash password
        $data['password'] = bcrypt($data['password']);

        // Extract roles before creating user
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        unset($data['password_confirmation']);

        // Create user
        $user = User::create($data);

        // Sync roles
        if (! empty($roles)) {
            $user->syncRoles($roles);
        }

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $user->toArray(), 'roles' => $roles])
            ->log('created');

        $user->notify(new \App\Notifications\SystemNotification('Welcome!', 'Welcome to the system.', null, 'success'));

        return $user;
    }
}
