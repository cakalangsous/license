<?php

namespace App\Actions\Core\Upload;

use Illuminate\Http\UploadedFile;

class UploadFile
{
    public function execute(UploadedFile $file): string
    {
        $link = $file->store('editor/images');

        return asset('storage/'.$link);
    }
}
