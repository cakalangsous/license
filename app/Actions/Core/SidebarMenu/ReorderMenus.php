<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class ReorderMenus
{
    public function execute(array $items): void
    {
        foreach ($items as $item) {
            SidebarMenu::where('id', $item['id'])->update([
                'parent_id' => $item['parent_id'],
                'order' => $item['order'],
                'section' => $item['section'],
            ]);
        }
    }
}
