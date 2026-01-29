<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Role\CreateRole;
use App\Actions\Core\Role\DeleteRole;
use App\Actions\Core\Role\GetFilteredRoles;
use App\Actions\Core\Role\UpdateRole;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StoreRoleRequest;
use App\Http\Requests\Core\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use Spatie\Permission\Models\Role;

class RoleController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'auth';
        $this->data['active_menu'] = 'roles';
        $this->data['title'] = 'Roles';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('roles_view'), 403);

        $this->data['paginatedRoles'] = (new GetFilteredRoles)->execute($request);

        return $this->inertia('Core/Roles/Index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        (new CreateRole)->execute($request->validated());

        return back()->with(['success' => true, 'message' => 'New Role added successfully!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        (new UpdateRole)->execute($role, $request->validated());

        return redirect(route('admin.roles.index'))
            ->with(['success' => true, 'message' => 'Role successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        abort_if(! auth()->user()->can('roles_delete'), 403);

        $name = $role->name;
        (new DeleteRole)->execute($role);

        return back()->with(['success' => true, 'message' => 'Role "'.$name.'" successfully deleted!']);
    }
}
