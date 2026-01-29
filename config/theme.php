<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Colors Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the default theme colors used throughout the application.
    | These values serve as fallbacks when database settings are not available.
    |
    | To change colors dynamically:
    | 1. Use the GUI theme settings page (when implemented)
    | 2. Or update values directly in the theme_settings database table
    | 3. Values are automatically cached and applied site-wide
    |
    | Available color keys:
    | - primary, primary_dark, primary_light
    | - secondary, success, danger, warning, info
    | - heading, body_bg, body_text
    | - sidebar_bg, sidebar_link
    |
    */

    'colors' => [
        'primary' => env('THEME_PRIMARY_COLOR', '#6771cf'),
        'primary_dark' => env('THEME_PRIMARY_DARK_COLOR', '#525ba8'),
        'primary_light' => env('THEME_PRIMARY_LIGHT_COLOR', '#8a92db'),
        'secondary' => env('THEME_SECONDARY_COLOR', '#6c757d'),
        'success' => env('THEME_SUCCESS_COLOR', '#198754'),
        'danger' => env('THEME_DANGER_COLOR', '#dc3545'),
        'warning' => env('THEME_WARNING_COLOR', '#ffc107'),
        'info' => env('THEME_INFO_COLOR', '#0dcaf0'),
        'heading' => env('THEME_HEADING_COLOR', '#25396f'),
        'body_bg' => env('THEME_BODY_BG_COLOR', '#f2f7ff'),
        'body_text' => env('THEME_BODY_TEXT_COLOR', '#607080'),
        'sidebar_bg' => env('THEME_SIDEBAR_BG_COLOR', '#ffffff'),
        'sidebar_link' => env('THEME_SIDEBAR_LINK_COLOR', '#25396f'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure caching for theme settings.
    |
    */

    'cache' => [
        'enabled' => env('THEME_CACHE_ENABLED', true),
        'ttl' => env('THEME_CACHE_TTL', 3600), // 1 hour
    ],

];
