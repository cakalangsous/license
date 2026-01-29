<?php

namespace App\Actions\Core\User;

use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UpdateUser
{
    public function execute(User $user, array $data, ?string $filepondFolder = null): User
    {
        // Handle avatar upload
        // Handle avatar upload
        if ($filepondFolder) {
            $temp = TemporaryFile::where('folder', $filepondFolder)->first();

            if ($temp) {
                $user->clearMediaCollection('avatar');

                $tempPath = storage_path('app/temp/'.$temp->folder.'/'.$temp->filename);
                if (! file_exists($tempPath)) {
                    $tempPath = storage_path('app/public/temp/'.$temp->folder.'/'.$temp->filename);
                }

                if (file_exists($tempPath)) {
                    $media = $user->addMedia($tempPath)->toMediaCollection('avatar');
                    $data['avatar'] = $media->getUrl();
                }

                $temp->delete();
                File::deleteDirectory(public_path('storage/temp/'.$temp->folder));
                File::deleteDirectory(storage_path('app/temp/'.$temp->folder));
            }
        }

        // Handle password
        if (empty($data['password'])) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } else {
            $data['password'] = bcrypt($data['password']);
            unset($data['password_confirmation']);
        }

        // Extract roles before updating user
        $roles = $data['roles'] ?? null;
        unset($data['roles']);

        // Update user
        $user->update($data);

        // Sync roles (only if user doesn't have Developer role)
        if ($roles !== null && ! $user->hasRole('Developer')) {
            $user->syncRoles($roles);
        }

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $user->getChanges()])
            ->log('updated');

        return $user;
    }
}
