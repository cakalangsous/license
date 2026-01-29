<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class ToggleMenuActive
{
    public function execute(SidebarMenu $menu): SidebarMenu
    {
        $menu->update(['is_active' => ! $menu->is_active]);

        return $menu;
    }
}
