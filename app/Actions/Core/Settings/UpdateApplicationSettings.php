<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;

class UpdateApplicationSettings
{
    public function execute(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $data])
            ->log('updated_application_settings');
    }
}
