<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;

class GetSettings
{
    public function execute(): array
    {
        $applicationSettings = Setting::where('group', 'application')->get()->keyBy('key');
        $themeSettings = Setting::where('group', 'theme')->get()->keyBy('key');
        $emailSettings = (new GetEmailSettings)->execute();

        return [
            'applicationSettings' => $applicationSettings,
            'themeSettings' => $themeSettings,
            'emailSettings' => $emailSettings,
        ];
    }
}
