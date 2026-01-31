<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'current_version',
        'envato_item_id',
        'regular_domain_limit',
        'extended_domain_limit',
        'encryption_salt',
        'is_active',
    ];

    protected $casts = [
        'regular_domain_limit' => 'integer',
        'extended_domain_limit' => 'integer',
        'is_active' => 'boolean',
    ];

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getDomainLimit(string $licenseType): int
    {
        return $licenseType === 'extended' 
            ? $this->extended_domain_limit 
            : $this->regular_domain_limit;
    }
}
