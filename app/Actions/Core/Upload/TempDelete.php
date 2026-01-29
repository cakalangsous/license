<?php

namespace App\Actions\Core\Upload;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\File;

class TempDelete
{
    public function execute(string $folder): bool
    {
        $temp = TemporaryFile::where('folder', $folder)->first();

        if (! $temp) {
            return false;
        }

        File::deleteDirectory(public_path('storage/temp/'.$temp->folder));
        $temp->delete();

        return true;
    }
}
