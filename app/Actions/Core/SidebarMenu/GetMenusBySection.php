<?php

namespace App\Actions\Core\SidebarMenu;

use App\Models\SidebarMenu;

class GetMenusBySection
{
    public function execute(): array
    {
        $sections = SidebarMenu::getSections();

        $menusBySection = [];
        foreach ($sections as $section) {
            $menusBySection[$section] = SidebarMenu::roots()
                ->bySection($section)
                ->with('allChildren')
                ->orderBy('order', 'asc')
                ->get();
        }

        $allMenus = SidebarMenu::orderBy('section', 'asc')
            ->orderBy('order', 'asc')
            ->get(['id', 'title', 'parent_id', 'section']);

        return [
            'menusBySection' => $menusBySection,
            'sections' => $sections,
            'allMenus' => $allMenus,
        ];
    }
}
