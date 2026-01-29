<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;

class ResetTheme
{
    private array $defaults = [
        'primary_color' => '#6771cf',
        'secondary_color' => '#6c757d',
        'success_color' => '#198754',
        'danger_color' => '#dc3545',
        'warning_color' => '#ffc107',
        'info_color' => '#0dcaf0',
        'light_bg_color' => '#f2f7ff',
        'dark_bg_color' => '#1a1d21',
        'sidebar_bg_light' => '#ffffff',
        'sidebar_bg_dark' => '#212529',
    ];

    public function execute(): void
    {
        foreach ($this->defaults as $key => $value) {
            Setting::set($key, $value, 'color', 'theme');
        }
    }
}
