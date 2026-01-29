<?php

namespace App\Actions\Core\Upload;

use Illuminate\Support\Facades\File;

class ListFiles
{
    public function execute(string $directory = 'storage/editor/images'): array
    {
        $files = File::files(public_path($directory));
        $images = [];

        foreach ($files as $file) {
            $images[] = [
                'url' => asset($directory.'/'.$file->getRelativePathname()),
                'thumb' => asset($directory.'/'.$file->getRelativePathname()),
            ];
        }

        return $images;
    }
}
