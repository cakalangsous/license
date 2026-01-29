<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class AddChildMenu
{
    public function execute(SidebarMenu $parent, array $data): SidebarMenu
    {
        $maxOrder = SidebarMenu::where('parent_id', $parent->id)->max('order') ?? -1;

        return SidebarMenu::create([
            'title' => $data['title'],
            'icon' => $data['icon'] ?? null,
            'route_name' => $data['route_name'] ?? null,
            'permission' => $data['permission'] ?? null,
            'parent_id' => $parent->id,
            'section' => $parent->section,
            'order' => $maxOrder + 1,
            'is_active' => true,
        ]);
    }
}
