<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class UpdateMenu
{
    public function execute(SidebarMenu $menu, array $data): SidebarMenu
    {
        $menu->update($data);

        return $menu;
    }
}
