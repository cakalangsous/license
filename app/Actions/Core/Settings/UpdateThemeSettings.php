<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;

class UpdateThemeSettings
{
    public function execute(array $data): void
    {
        $changed = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value, 'color', 'theme');
                $changed[$key] = $value;
            }
        }

        if (! empty($changed)) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['attributes' => $changed])
                ->log('updated_theme_settings');
        }
    }
}
