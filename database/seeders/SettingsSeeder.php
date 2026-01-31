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

            // License Settings - Defaults
            [
                'key' => 'default_domain_limit_regular',
                'value' => '1',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Domain Limit (Regular License)',
                'description' => 'Default domain limit for regular licenses',
            ],
            [
                'key' => 'default_domain_limit_extended',
                'value' => '5',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Domain Limit (Extended License)',
                'description' => 'Default domain limit for extended licenses',
            ],
            [
                'key' => 'default_support_period_months',
                'value' => '6',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Support Period (Months)',
                'description' => 'Default support period for new licenses',
            ],

            // License Settings - Heartbeat
            [
                'key' => 'heartbeat_grace_period_hours',
                'value' => '72',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Heartbeat Grace Period (Hours)',
                'description' => 'How long before an activation is considered stale',
            ],
            [
                'key' => 'heartbeat_required',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Require Heartbeat',
                'description' => 'Block access if heartbeat not received within grace period',
            ],

            // License Settings - Security
            [
                'key' => 'auto_block_suspicious_domains',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Auto-Block Suspicious Domains',
                'description' => 'Automatically blacklist domains with excessive failures',
            ],
            [
                'key' => 'suspicious_threshold_count',
                'value' => '10',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Suspicious Activity Threshold',
                'description' => 'Number of failed attempts to trigger alert',
            ],
            [
                'key' => 'suspicious_threshold_minutes',
                'value' => '5',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Suspicious Activity Window (Minutes)',
                'description' => 'Time window for counting failed attempts',
            ],

            // License Settings - API Rate Limits
            [
                'key' => 'rate_limit_verify',
                'value' => '30',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Rate Limit: Verify (per minute)',
            ],
            [
                'key' => 'rate_limit_activate',
                'value' => '10',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Rate Limit: Activate/Deactivate (per minute)',
            ],
            [
                'key' => 'rate_limit_heartbeat',
                'value' => '60',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Rate Limit: Heartbeat (per minute)',
            ],

            // License Settings - Notifications
            [
                'key' => 'notify_on_new_sale',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Notify on New Sale',
            ],
            [
                'key' => 'notify_on_suspicious_activity',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Notify on Suspicious Activity',
            ],
            [
                'key' => 'support_expiry_warning_days',
                'value' => '7',
                'type' => 'number',
                'group' => 'license',
                'label' => 'Support Expiry Warning (Days)',
                'description' => 'Days before support expiry to send warning',
            ],
            [
                'key' => 'notification_email',
                'value' => '',
                'type' => 'email',
                'group' => 'license',
                'label' => 'Notification Email',
                'description' => 'Email address for license notifications (leave empty for admin)',
            ],

            // License Settings - Envato Integration
            [
                'key' => 'envato_webhook_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Enable Envato Webhooks',
            ],
            [
                'key' => 'envato_webhook_secret',
                'value' => '',
                'type' => 'password',
                'group' => 'license',
                'label' => 'Envato Webhook Secret',
            ],
            [
                'key' => 'envato_personal_token',
                'value' => '',
                'type' => 'password',
                'group' => 'license',
                'label' => 'Envato Personal Token',
            ],
            [
                'key' => 'envato_auto_create_license',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'license',
                'label' => 'Auto-Create License on Sale',
                'description' => 'Automatically create license when Envato sale webhook is received',
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
