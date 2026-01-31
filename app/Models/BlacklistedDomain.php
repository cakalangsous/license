<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistedDomain extends Model
{
    protected $fillable = [
        'pattern',
        'reason',
    ];

    /**
     * Check if a domain matches any blacklist pattern.
     */
    public static function isBlacklisted(string $domain): bool
    {
        $patterns = self::pluck('pattern')->toArray();

        foreach ($patterns as $pattern) {
            if (self::matchesPattern($domain, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Match domain against a wildcard pattern.
     * Supports patterns like: *.nulled.*, nulled.to, *.warez.*
     */
    private static function matchesPattern(string $domain, string $pattern): bool
    {
        // Convert wildcard pattern to regex
        $regex = '/^' . str_replace(
            ['.', '*'],
            ['\.', '.*'],
            $pattern
        ) . '$/i';

        return (bool) preg_match($regex, $domain);
    }
}
