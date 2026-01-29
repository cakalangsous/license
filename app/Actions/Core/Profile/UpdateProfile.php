<?php

namespace App\Actions\Core\Profile;

use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UpdateProfile
{
    public function execute(User $user, array $data, ?string $filepondFolder = null): User
    {
        // Avatar Handling (FilePond)
        // Avatar Handling (FilePond)
        if ($filepondFolder) {
            $temp = TemporaryFile::where('folder', $filepondFolder)->first();

            if ($temp) {
                // Remove old avatar media
                $user->clearMediaCollection('avatar');

                // Add new media
                // We point to the temp file. Spatie will move it.
                // Temp file is at storage_path('app/temp/' . $temp->folder . '/' . $temp->filename)
                // or public if that's where we put it. But CreateUser/UpdateUser put it in `temp` disk usually?
                // Actually TemporaryFileController usually stores in 'local' disk 'temp/' folder.

                $tempPath = storage_path('app/temp/'.$temp->folder.'/'.$temp->filename);
                if (! file_exists($tempPath)) {
                    $tempPath = storage_path('app/public/temp/'.$temp->folder.'/'.$temp->filename);
                }

                if (file_exists($tempPath)) {
                    $media = $user->addMedia($tempPath)
                        ->toMediaCollection('avatar');

                    // Update avatar column with the url
                    $data['avatar'] = $media->getUrl();
                }

                $temp->delete();
                // Spatie handles the file move, so we don't need manual cleanup of the source if we use addMedia which copies/moves.
                // But addMedia preserves original by default? No, it moves/copies.
                // If we want to be clean, we can delete the temp folder.
                File::deleteDirectory(public_path('storage/temp/'.$temp->folder));
                File::deleteDirectory(storage_path('app/temp/'.$temp->folder));
            }
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'] ?? $user->avatar,
        ]);

        return $user;
    }
}
