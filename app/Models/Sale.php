<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = [
        'license_id',
        'product_id',
        'marketplace_id',
        'sale_date',
        'gross_amount',
        'marketplace_fee',
        'net_amount',
        'currency',
        'synced_at',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'gross_amount' => 'decimal:2',
        'marketplace_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'synced_at' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }
}
