<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class DeleteMenu
{
    public function execute(SidebarMenu $menu): bool
    {
        return $menu->delete();
    }
}
