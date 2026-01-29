<?php

namespace App\Actions\Core\Upload;

use App\Models\TemporaryFile;
use Illuminate\Http\UploadedFile;

class TempUpload
{
    public function execute(UploadedFile $file): string
    {
        $filename = sha1(uniqid().now()->timestamp).'.'.$file->getClientOriginalExtension();
        $folder = uniqid().now()->timestamp;

        $file->storeAs('temp/'.$folder, $filename);

        TemporaryFile::create([
            'folder' => $folder,
            'filename' => $filename,
        ]);

        return $folder;
    }
}
