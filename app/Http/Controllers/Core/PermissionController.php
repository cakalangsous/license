<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Permission\CreatePermission;
use App\Actions\Core\Permission\DeletePermission;
use App\Actions\Core\Permission\GetFilteredPermissions;
use App\Actions\Core\Permission\UpdatePermission;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StorePermissionRequest;
use App\Http\Requests\Core\UpdatePermissionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'auth';
        $this->data['active_menu'] = 'permissions';
        $this->data['title'] = 'Permissions';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('permissions_view'), 403);

        $result = (new GetFilteredPermissions)->execute($request);

        $this->data['paginatedPermissions'] = $result['paginatedPermissions'];
        $this->data['tables'] = $result['tables'];

        return inertia('Core/Permissions/Index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        (new CreatePermission)->execute($request->validated());

        return back()->with(['success' => true, 'message' => 'New Permission data is saved!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);

        (new UpdatePermission)->execute($permission, $request->validated());

        return redirect(route('admin.permissions.index'))
            ->with(['success' => true, 'message' => 'Permission data is updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        abort_if(! auth()->user()->can('permissions_delete'), 403);

        $name = $permission->name;
        (new DeletePermission)->execute($permission);

        return back()->with(['success' => true, 'message' => 'Permission "'.$name.'" successfully deleted!']);
    }
}
