<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view("admin.role.role", compact("roles"));
    }
    public function create()
    {
        return view("admin.role.addrole");
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::with('Roles')
        ->whereDoesntHave('roles', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        return view("admin.role.addrole", compact("role", "permissions"));
    }
    public function store(Request $request)
    {
        try {
            Role::create([
                'name' => $request->name,
            ]);
            return redirect()->route("admin.role")->with("success", "Role created successfully");
        } catch (\Exception $e) {
            return redirect()->route("admin.role")->with("error", "Something went wrong");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Role::where('id', $id)
                ->update([
                    'name' => $request->name,
                ]);
            return redirect()->route("admin.role")->with("success", "Role updated successfully");
        } catch (\Exception $e) {
            return redirect()->route("admin.role")->with("error", $e->getMessage());
        }
    }
    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route("admin.role")->with("success", "Role deleted successfully");
    }

    public function givePermission(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            if (!$request->has('permission')) {
                return back()->with("error", "Permission not specified");
            }

            if ($role->hasPermissionTo($request->permission)) {
                return back()->with("error", "Permission exists already");
            }

            $role->givePermissionTo($request->permission);
            return back()->with("success", "Permission added successfully");
        } catch (\Exception $e) {
            return back()->with("error", "Failed to add permission: " . $e->getMessage());
        }
    }
    public function revokePermission($roleId, $permission)
    {
        try {
            $role = Role::findOrFail($roleId);

            if (!$role->hasPermissionTo($permission)) {
                return back()->with("error", "Permission does not exist");
            }

            $role->revokePermissionTo($permission);
            return back()->with("success", "Permission removed successfully");
        } catch (\Exception $e) {
            return back()->with("error", "Failed to remove permission: " . $e->getMessage());
        }
    }
}
