<?php

namespace App\Models;

use App\Services\ThemeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Cache key prefix
     */
    protected static string $cachePrefix = 'setting_';

    /**
     * Check if settings table exists
     */
    protected static function tableExists(): bool
    {
        static $exists = null;

        if ($exists === null) {
            try {
                $exists = Schema::hasTable('settings');
            } catch (\Exception $e) {
                $exists = false;
            }
        }

        return $exists;
    }

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (! static::tableExists()) {
            return $default;
        }

        return Cache::remember(static::$cachePrefix.$key, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value, ?string $type = null, ?string $group = null): void
    {
        if (! static::tableExists()) {
            return;
        }

        $data = ['value' => $value];

        if ($type) {
            $data['type'] = $type;
        }
        if ($group) {
            $data['group'] = $group;
        }

        static::updateOrCreate(['key' => $key], $data);

        Cache::forget(static::$cachePrefix.$key);
        Cache::forget('settings_all');
        Cache::forget('settings_group_'.($group ?? 'application'));
    }

    /**
     * Get all settings as key-value array
     */
    public static function allAsArray(): array
    {
        if (! static::tableExists()) {
            return [];
        }

        return Cache::remember('settings_all', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group): array
    {
        if (! static::tableExists()) {
            return [];
        }

        return Cache::remember('settings_group_'.$group, 3600, function () use ($group) {
            return static::where('group', $group)->get()->toArray();
        });
    }

    /**
     * Get application settings
     */
    public static function getApplicationSettings(): array
    {
        return static::getByGroup('application');
    }

    /**
     * Get theme settings
     */
    public static function getThemeSettings(): array
    {
        return static::getByGroup('theme');
    }

    /**
     * Get color settings as CSS variables
     */
    public static function getColorCssVariables(): string
    {
        $settings = static::where('group', 'theme')
            ->where('type', 'color')
            ->pluck('value', 'key')
            ->toArray();

        $css = ":root {\n";
        foreach ($settings as $key => $value) {
            if ($value) {
                $cssKey = str_replace('_', '-', $key);
                $css .= "    --{$cssKey}: {$value};\n";
            }
        }
        $css .= "}\n";

        return $css;
    }

    /**
     * Get license settings
     */
    public static function getLicenseSettings(): array
    {
        return static::getByGroup('license');
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('settings_all');
        Cache::forget('settings_group_application');
        Cache::forget('settings_group_theme');
        Cache::forget('settings_group_license');

        static::pluck('key')->each(function ($key) {
            Cache::forget(static::$cachePrefix.$key);
        });

        // Also clear theme CSS cache
        ThemeService::clearCache();
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget(static::$cachePrefix.$setting->key);
            Cache::forget('settings_all');
            Cache::forget('settings_group_'.$setting->group);

            // Clear theme CSS cache when theme settings change
            if ($setting->group === 'theme') {
                ThemeService::clearCache();
            }
        });

        static::deleted(function ($setting) {
            Cache::forget(static::$cachePrefix.$setting->key);
            Cache::forget('settings_all');
            Cache::forget('settings_group_'.$setting->group);

            // Clear theme CSS cache when theme settings are deleted
            if ($setting->group === 'theme') {
                ThemeService::clearCache();
            }
        });
    }
}
