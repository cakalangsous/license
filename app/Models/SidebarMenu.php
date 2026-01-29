<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidebarMenu extends Model
{
    protected $fillable = [
        'title',
        'route_name',
        'icon',
        'section',
        'permission',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SidebarMenu::class, 'parent_id');
    }

    /**
     * Get child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(SidebarMenu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get all descendants recursively.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Scope to get only root level menu items.
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get menu items by section.
     */
    public function scopeBySection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Scope for active menus only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get hierarchical menu tree by section.
     */
    public static function getTree(?string $section = null)
    {
        $query = static::roots()->with('allChildren')->orderBy('order');

        if ($section) {
            $query->bySection($section);
        }

        return $query->get();
    }

    /**
     * Get distinct sections.
     */
    public static function getSections()
    {
        return static::distinct()->pluck('section')->filter()->values();
    }
}
