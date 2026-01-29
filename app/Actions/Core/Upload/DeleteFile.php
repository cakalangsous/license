<?php

namespace App\Actions\Core\Upload;

use Illuminate\Support\Facades\File;

class DeleteFile
{
    public function execute(string $src): bool
    {
        if (! File::exists($src)) {
            return false;
        }

        return File::delete($src);
    }
}
