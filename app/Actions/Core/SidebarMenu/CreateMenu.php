<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class CreateMenu
{
    public function execute(array $data): SidebarMenu
    {
        $maxOrder = SidebarMenu::bySection($data['section'])
            ->whereNull('parent_id')
            ->max('order') ?? -1;

        $data['order'] = $maxOrder + 1;
        $data['is_active'] = $data['is_active'] ?? true;

        return SidebarMenu::create($data);
    }
}
