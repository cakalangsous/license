<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ThemeService
{
    /**
     * Cache key for theme CSS
     */
    protected static string $cacheKey = 'theme_css_variables';

    /**
     * Cache duration in seconds (1 hour)
     */
    protected static int $cacheDuration = 3600;

    /**
     * Get all theme CSS variables as a string
     */
    public static function getCssVariables(): string
    {
        return Cache::remember(static::$cacheKey, static::$cacheDuration, function () {
            return static::generateCssVariables();
        });
    }

    /**
     * Generate CSS variables from theme settings
     */
    protected static function generateCssVariables(): string
    {
        $primaryColor = Setting::get('primary_color', '#6771cf');
        $secondaryColor = Setting::get('secondary_color', '#6c757d');
        $successColor = Setting::get('success_color', '#198754');
        $dangerColor = Setting::get('danger_color', '#dc3545');
        $warningColor = Setting::get('warning_color', '#ffc107');
        $infoColor = Setting::get('info_color', '#0dcaf0');
        $lightBgColor = Setting::get('light_bg_color', '#f2f7ff');
        $darkBgColor = Setting::get('dark_bg_color', '#1a1d21');
        $sidebarBgLight = Setting::get('sidebar_bg_light', '#ffffff');
        $sidebarBgDark = Setting::get('sidebar_bg_dark', '#212529');

        // Generate color scales
        $primaryScale = static::generateColorScale($primaryColor);
        $secondaryScale = static::generateColorScale($secondaryColor);

        $css = ":root {\n";

        // Primary color scale
        $css .= "    /* Primary color scale */\n";
        $css .= "    --color-primary: {$primaryColor};\n";
        foreach ($primaryScale as $shade => $color) {
            $css .= "    --color-primary-{$shade}: {$color};\n";
        }

        $css .= "\n    /* Secondary color scale */\n";
        $css .= "    --color-secondary: {$secondaryColor};\n";
        foreach ($secondaryScale as $shade => $color) {
            $css .= "    --color-secondary-{$shade}: {$color};\n";
        }

        $css .= "\n    /* Other theme colors */\n";
        $css .= "    --color-success: {$successColor};\n";
        $css .= "    --color-danger: {$dangerColor};\n";
        $css .= "    --color-warning: {$warningColor};\n";
        $css .= "    --color-info: {$infoColor};\n";
        $css .= "    --color-body-bg: {$lightBgColor};\n";

        $css .= "\n    /* Sidebar colors (light mode) */\n";
        $css .= "    --color-sidebar-bg: {$sidebarBgLight};\n";

        $css .= "}\n";

        // Dark mode overrides
        $css .= "\n.dark {\n";
        $css .= "    --color-body-bg: {$darkBgColor};\n";
        $css .= "    --color-sidebar-bg: {$sidebarBgDark};\n";
        $css .= "}\n";

        return $css;
    }

    /**
     * Generate a color scale (50-900) from a base color
     *
     * @param  string  $hexColor  The base hex color (e.g., #6771cf)
     * @return array<int, string> Array of shade => hex color
     */
    public static function generateColorScale(string $hexColor): array
    {
        $rgb = static::hexToRgb($hexColor);

        if (! $rgb) {
            return static::getDefaultScale();
        }

        $hsl = static::rgbToHsl($rgb['r'], $rgb['g'], $rgb['b']);

        // Define lightness values for each shade
        // Lighter shades (50-400) increase lightness, darker shades (600-900) decrease it
        $shadeConfigs = [
            50 => ['lightness' => 0.95, 'saturation' => 0.3],
            100 => ['lightness' => 0.90, 'saturation' => 0.5],
            200 => ['lightness' => 0.80, 'saturation' => 0.6],
            300 => ['lightness' => 0.70, 'saturation' => 0.7],
            400 => ['lightness' => 0.60, 'saturation' => 0.85],
            500 => ['lightness' => null, 'saturation' => null], // Base color
            600 => ['lightness' => 0.40, 'saturation' => 0.9],
            700 => ['lightness' => 0.30, 'saturation' => 0.85],
            800 => ['lightness' => 0.20, 'saturation' => 0.8],
            900 => ['lightness' => 0.12, 'saturation' => 0.75],
        ];

        $scale = [];

        foreach ($shadeConfigs as $shade => $config) {
            if ($shade === 500) {
                // Use the original color for 500
                $scale[$shade] = $hexColor;
            } else {
                $newHsl = [
                    'h' => $hsl['h'],
                    's' => $hsl['s'] * $config['saturation'],
                    'l' => $config['lightness'],
                ];

                $newRgb = static::hslToRgb($newHsl['h'], $newHsl['s'], $newHsl['l']);
                $scale[$shade] = static::rgbToHex($newRgb['r'], $newRgb['g'], $newRgb['b']);
            }
        }

        return $scale;
    }

    /**
     * Convert hex color to RGB
     */
    public static function hexToRgb(string $hex): ?array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6) {
            return null;
        }

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Convert RGB to hex
     */
    public static function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x',
            max(0, min(255, $r)),
            max(0, min(255, $g)),
            max(0, min(255, $b))
        );
    }

    /**
     * Convert RGB to HSL
     */
    public static function rgbToHsl(int $r, int $g, int $b): array
    {
        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ($max + $min) / 2;

        if ($max === $min) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

            switch ($max) {
                case $r:
                    $h = (($g - $b) / $d + ($g < $b ? 6 : 0)) / 6;
                    break;
                case $g:
                    $h = (($b - $r) / $d + 2) / 6;
                    break;
                case $b:
                    $h = (($r - $g) / $d + 4) / 6;
                    break;
            }
        }

        return ['h' => $h, 's' => $s, 'l' => $l];
    }

    /**
     * Convert HSL to RGB
     */
    public static function hslToRgb(float $h, float $s, float $l): array
    {
        if ($s === 0.0) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;

            $r = static::hueToRgb($p, $q, $h + 1 / 3);
            $g = static::hueToRgb($p, $q, $h);
            $b = static::hueToRgb($p, $q, $h - 1 / 3);
        }

        return [
            'r' => (int) round($r * 255),
            'g' => (int) round($g * 255),
            'b' => (int) round($b * 255),
        ];
    }

    /**
     * Helper function for HSL to RGB conversion
     */
    protected static function hueToRgb(float $p, float $q, float $t): float
    {
        if ($t < 0) {
            $t += 1;
        }
        if ($t > 1) {
            $t -= 1;
        }
        if ($t < 1 / 6) {
            return $p + ($q - $p) * 6 * $t;
        }
        if ($t < 1 / 2) {
            return $q;
        }
        if ($t < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }

    /**
     * Get default color scale (fallback)
     */
    protected static function getDefaultScale(): array
    {
        return [
            50 => '#f0f1f9',
            100 => '#e1e3f4',
            200 => '#c3c7e9',
            300 => '#a5abde',
            400 => '#878fd3',
            500 => '#6771cf',
            600 => '#525ba8',
            700 => '#3e447e',
            800 => '#292d54',
            900 => '#15172a',
        ];
    }

    /**
     * Clear the theme CSS cache
     */
    public static function clearCache(): void
    {
        Cache::forget(static::$cacheKey);
    }

    /**
     * Get the primary color
     */
    public static function getPrimaryColor(): string
    {
        return Setting::get('primary_color', '#6771cf');
    }

    /**
     * Get the secondary color
     */
    public static function getSecondaryColor(): string
    {
        return Setting::get('secondary_color', '#6c757d');
    }
}
