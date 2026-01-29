<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\Access\GetAccessMatrix;
use App\Actions\Core\Access\UpdateRolePermissions;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\UpdateAccessRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'auth';
        $this->data['active_menu'] = 'access';
        $this->data['title'] = 'Access';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('access_view'), 403);

        $accessData = (new GetAccessMatrix)->execute($request);

        return inertia('Core/Access/Index', [
            ...$this->data,
            ...$accessData,
        ]);
    }

    public function getAccessByRole(Request $req)
    {
        abort_if(! $req->ajax() || ! auth()->user()->can('access_view'), 403);

        $req->validate(['role' => 'required']);

        $role = Role::findOrFail($req->role);
        $rolePerms = $role->permissions;
        $perms = Permission::all();

        $groupPermsGrouping = [];
        foreach ($perms as $perm) {
            $groupName = '';
            $permTmpArr = explode('_', $perm->name);

            if (isset($permTmpArr[0]) && ! empty($permTmpArr[0])) {
                $groupName = strtolower($permTmpArr[0]);
            }

            if ($perm->table_name != null) {
                $groupName = strtolower($perm->table_name);
            }

            $groupPermsGrouping[$groupName][] = $perm;
        }

        return response()->json([
            'success' => true,
            'message' => "Get {$role->name} permissions success!",
            'perms' => $groupPermsGrouping,
            'role_perms' => $rolePerms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccessRequest $request, $role): RedirectResponse
    {
        $roleData = Role::findOrFail($role);

        (new UpdateRolePermissions)->execute($roleData, $request->perms ?? []);

        return redirect(route('admin.access.index'))
            ->with(['success' => true, 'message' => "Permissions for {$roleData->name} are updated!"]);
    }
}
