<?php

namespace App\Actions\Core\Settings;

use App\Models\Setting;

class UpdateLicenseSettings
{
    public function execute(array $data): void
    {
        // License Defaults
        Setting::set('default_domain_limit_regular', $data['default_domain_limit_regular'] ?? '1', 'number', 'license');
        Setting::set('default_domain_limit_extended', $data['default_domain_limit_extended'] ?? '5', 'number', 'license');
        Setting::set('default_support_period_months', $data['default_support_period_months'] ?? '6', 'number', 'license');
        
        // Heartbeat Settings
        Setting::set('heartbeat_grace_period_hours', $data['heartbeat_grace_period_hours'] ?? '72', 'number', 'license');
        Setting::set('heartbeat_required', $data['heartbeat_required'] ? 'true' : 'false', 'boolean', 'license');
        
        // Security Settings
        Setting::set('auto_block_suspicious_domains', $data['auto_block_suspicious_domains'] ? 'true' : 'false', 'boolean', 'license');
        Setting::set('suspicious_threshold_count', $data['suspicious_threshold_count'] ?? '10', 'number', 'license');
        Setting::set('suspicious_threshold_minutes', $data['suspicious_threshold_minutes'] ?? '5', 'number', 'license');
        
        // Rate Limits
        Setting::set('rate_limit_verify', $data['rate_limit_verify'] ?? '30', 'number', 'license');
        Setting::set('rate_limit_activate', $data['rate_limit_activate'] ?? '10', 'number', 'license');
        Setting::set('rate_limit_heartbeat', $data['rate_limit_heartbeat'] ?? '60', 'number', 'license');
        
        // Notifications
        Setting::set('notify_on_new_sale', $data['notify_on_new_sale'] ? 'true' : 'false', 'boolean', 'license');
        Setting::set('notify_on_suspicious_activity', $data['notify_on_suspicious_activity'] ? 'true' : 'false', 'boolean', 'license');
        Setting::set('support_expiry_warning_days', $data['support_expiry_warning_days'] ?? '7', 'number', 'license');
        Setting::set('notification_email', $data['notification_email'] ?? '', 'email', 'license');
        
        // Envato Integration
        Setting::set('envato_webhook_enabled', $data['envato_webhook_enabled'] ? 'true' : 'false', 'boolean', 'license');
        Setting::set('envato_webhook_secret', $data['envato_webhook_secret'] ?? '', 'password', 'license');
        Setting::set('envato_personal_token', $data['envato_personal_token'] ?? '', 'password', 'license');
        Setting::set('envato_auto_create_license', $data['envato_auto_create_license'] ? 'true' : 'false', 'boolean', 'license');
        
        // Clear cache
        Setting::clearCache();
    }
}
