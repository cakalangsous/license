<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\SidebarMenu\AddChildMenu;
use App\Actions\Core\SidebarMenu\CreateMenu;
use App\Actions\Core\SidebarMenu\DeleteMenu;
use App\Actions\Core\SidebarMenu\GetMenusBySection;
use App\Actions\Core\SidebarMenu\ReorderMenus;
use App\Actions\Core\SidebarMenu\ToggleMenuActive;
use App\Actions\Core\SidebarMenu\UpdateMenu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\StoreSidebarMenuRequest;
use App\Models\SidebarMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SidebarMenuController extends Controller
{
    public function index(): InertiaResponse
    {
        $data = (new GetMenusBySection)->execute();

        return Inertia::render('Core/SidebarMenuBuilder/Index', $data);
    }

    public function store(StoreSidebarMenuRequest $request): RedirectResponse
    {
        (new CreateMenu)->execute($request->validated());

        return redirect()->back()->with('success', 'Menu created successfully.');
    }

    public function update(StoreSidebarMenuRequest $request, SidebarMenu $sidebarMenu): RedirectResponse
    {
        (new UpdateMenu)->execute($sidebarMenu, $request->validated());

        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(SidebarMenu $sidebarMenu): RedirectResponse
    {
        (new DeleteMenu)->execute($sidebarMenu);

        return redirect()->back()->with('success', 'Menu deleted successfully.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:sidebar_menus,id',
            'items.*.parent_id' => 'nullable|exists:sidebar_menus,id',
            'items.*.order' => 'required|integer',
            'items.*.section' => 'required|string',
        ]);

        (new ReorderMenus)->execute($request->items);

        return redirect()->back()->with('success', 'Menu order updated.');
    }

    public function toggleActive(SidebarMenu $sidebarMenu): RedirectResponse
    {
        (new ToggleMenuActive)->execute($sidebarMenu);

        return redirect()->back()->with('success', 'Menu status updated.');
    }

    public function addChild(Request $request, SidebarMenu $sidebarMenu): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'permission' => 'nullable|string|max:255',
        ]);

        (new AddChildMenu)->execute($sidebarMenu, $request->all());

        return redirect()->back()->with('success', 'Child menu added successfully.');
    }
}
