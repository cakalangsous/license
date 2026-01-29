<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Application Settings
            [
                'key' => 'app_name',
                'value' => 'Laraku',
                'type' => 'text',
                'group' => 'application',
                'label' => 'Application Name',
            ],
            [
                'key' => 'meta_description',
                'value' => 'A powerfull admin panel with crud generator.',
                'type' => 'textarea',
                'group' => 'application',
                'label' => 'Meta Description',
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'laravel, web, application, laraku, admin panel, crud generator, crud buillder',
                'type' => 'text',
                'group' => 'application',
                'label' => 'Meta Keywords',
            ],

            // Theme Settings - Colors
            [
                'key' => 'primary_color',
                'value' => '#6771cf',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Primary Color',
            ],
            [
                'key' => 'secondary_color',
                'value' => '#6c757d',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Secondary Color',
            ],
            [
                'key' => 'success_color',
                'value' => '#198754',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Success Color',
            ],
            [
                'key' => 'danger_color',
                'value' => '#dc3545',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Danger Color',
            ],
            [
                'key' => 'warning_color',
                'value' => '#ffc107',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Warning Color',
            ],
            [
                'key' => 'info_color',
                'value' => '#0dcaf0',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Info Color',
            ],

            // Theme Settings - Background Colors
            [
                'key' => 'light_bg_color',
                'value' => '#f2f7ff',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Light Theme Background',
            ],
            [
                'key' => 'dark_bg_color',
                'value' => '#1a1d21',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Dark Theme Background',
            ],
            [
                'key' => 'sidebar_bg_light',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Sidebar Background (Light)',
            ],
            [
                'key' => 'sidebar_bg_dark',
                'value' => '#212529',
                'type' => 'color',
                'group' => 'theme',
                'label' => 'Sidebar Background (Dark)',
            ],

            // Theme Settings - Images (set to null)
            [
                'key' => 'app_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'theme',
                'label' => 'Application Logo',
            ],
            [
                'key' => 'app_logo_dark',
                'value' => null,
                'type' => 'image',
                'group' => 'theme',
                'label' => 'Application Logo (Dark Mode)',
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'theme',
                'label' => 'Favicon',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clear the settings cache after seeding
        Setting::clearCache();
    }
}
