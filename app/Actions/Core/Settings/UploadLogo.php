<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadLogo
{
    public function execute(UploadedFile $file, string $type): string
    {
        // Delete old file if exists
        $oldValue = Setting::get($type);
        if ($oldValue && Storage::disk('public')->exists($oldValue)) {
            Storage::disk('public')->delete($oldValue);
        }

        // Store new file
        $filename = $type.'_'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('settings', $filename, 'public');

        Setting::set($type, $path, 'image', 'theme');

        return $path;
    }
}
