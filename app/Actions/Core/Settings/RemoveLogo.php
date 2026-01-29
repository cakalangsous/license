<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class RemoveLogo
{
    public function execute(string $type): void
    {
        $oldValue = Setting::get($type);

        if ($oldValue && Storage::disk('public')->exists($oldValue)) {
            Storage::disk('public')->delete($oldValue);
        }

        Setting::set($type, null, 'image', 'theme');
    }
}
