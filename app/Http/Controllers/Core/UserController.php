<?php

namespace App\Http\Controllers\Core;

use App\Actions\Core\User\CreateUser;
use App\Actions\Core\User\DeleteUser;
use App\Actions\Core\User\GetFilteredUsers;
use App\Actions\Core\User\ToggleUserBan;
use App\Actions\Core\User\UpdateUser;
use App\Http\Controllers\CoreController;
use App\Http\Requests\Core\StoreUserRequest;
use App\Http\Requests\Core\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;
use Spatie\Permission\Models\Role;

class UserController extends CoreController
{
    public function __construct()
    {
        $this->data['parent_menu'] = 'auth';
        $this->data['active_menu'] = 'users';
        $this->data['title'] = 'Users';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        abort_if(! auth()->user()->can('users_view'), 403);

        $this->data['paginatedUsers'] = (new GetFilteredUsers)->execute($request);

        return $this->inertia('Core/Users/Index', $this->data);
    }

    public function toggleBan(Request $request, User $user): RedirectResponse
    {
        abort_if(! auth()->user()->can('users_update'), 403);
        abort_if($user->id == 1, 404, 'User not found');

        $user = (new ToggleUserBan)->execute($user);
        $banStatus = $user->is_banned ? 'banned' : 'unbanned';

        return back()->with(['success' => true, 'message' => "$user->name has been $banStatus!"]);
    }

    public function create(): InertiaResponse
    {
        abort_if(! auth()->user()->can('users_create'), 403);

        $this->data['title'] = 'Create User';
        $this->data['roles'] = Role::where('id', '>', 1)
            ->where('name', '!=', 'Developer')
            ->get(['id', 'name']);

        return $this->inertia('Core/Users/Create', $this->data);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        (new CreateUser)->execute($request->validated(), $request->filepond);

        return redirect(route('admin.users.index'))
            ->with(['success' => true, 'message' => 'New user data is saved!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): InertiaResponse
    {
        abort_if(! auth()->user()->can('users_update'), 403);
        abort_if($user->id == 1 && auth()->user()->id != 1, 404);

        $this->data['title'] = 'Edit '.$user->name.' data';
        $this->data['user'] = $user;

        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->id;
        }

        $this->data['roles'] = Role::where('id', '>', 1)
            ->where('name', '!=', 'Developer')
            ->get(['id', 'name']);
        $this->data['user_roles'] = $roles;

        return $this->inertia('Core/Users/Edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        (new UpdateUser)->execute($user, $request->validated(), $request->filepond);

        return redirect(route('admin.users.index'))
            ->with(['success' => true, 'message' => $user->name.' data updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_if(! auth()->user()->can('users_delete'), 403);

        if (auth()->user()->id == $user->id) {
            return back()->with(['success' => false, 'message' => "You can't delete your own account!"]);
        }

        if ($user->id == 1) {
            return back()->with(['success' => false, 'message' => 'Cannot delete this user!']);
        }

        $name = $user->name;
        (new DeleteUser)->execute($user);

        return back()->with(['success' => true, 'message' => "$name has been deleted!"]);
    }

    public function export()
    {
        abort_if(! auth()->user()->can('users_view'), 403);

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\UsersExport, 'users.xlsx');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        abort_if(! auth()->user()->can('users_delete'), 403);

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        $ids = $request->ids;

        // Prevent deleting self or Super Admin (ID 1)
        if (in_array(auth()->id(), $ids)) {
            return back()->with(['success' => false, 'message' => "You can't delete your own account!"]);
        }
        if (in_array(1, $ids)) {
            return back()->with(['success' => false, 'message' => 'Cannot delete the Super Admin!']);
        }

        foreach ($ids as $id) {
            $user = User::findOrFail($id);
            (new DeleteUser)->execute($user);
        }

        return back()->with(['success' => true, 'message' => count($ids).' users deleted!']);
    }
}
