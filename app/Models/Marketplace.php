<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Marketplace extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'api_token',
        'api_base_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'api_token',
    ];

    protected function apiToken(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? decrypt($value) : null,
            set: fn (?string $value) => $value ? encrypt($value) : null,
        );
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
