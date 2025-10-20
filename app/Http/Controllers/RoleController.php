<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny',Role::class);
        $roles = Role::whereNotIn('name', ['super admin'])->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create',Role::class);
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create',Role::class);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $request->name , 'guard_name' => 'web']);

        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $this->authorize('update',Role::class);
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update',Role::class);
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $this->authorize('delete',Role::class);
        $role = Role::findOrFail($id);
        
        $usersCount = $role->users()->count();
        
        if ($usersCount > 0) {
            return redirect()
                ->route('roles.index')
                ->with('error', "Cannot delete role '{$role->name}'. {$usersCount} user(s) are currently assigned to this role. Please remove all users from this role before deleting it.");
        }
        
        $role->delete();
        return redirect()
            ->route('roles.index')
            ->with('success', "Role '{$role->name}' has been deleted successfully.");
    }

    public function forceDestroy($id)
    {
        $this->authorize('delete',Role::class);
        $role = Role::findOrFail($id);
        
        $usersCount = $role->users()->count();
        
        if ($usersCount > 0) {
            $role->users()->each(function ($user) {
                $user->delete();
            });
        }
        
        $role->delete();
        
        return redirect()
            ->route('roles.index')
            ->with('success', "Role '{$role->name}' and {$usersCount} user(s) have been deleted successfully.");
    }
}
