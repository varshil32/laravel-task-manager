<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view("admin.permission.permission", compact("permissions"));
    }
    public function create()
    {
        return view("admin.permission.addpermission");
    }
    public function store(Request $request)
    {
        try {
            $permission = Permission::create(['name' => $request->name]);
            
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $adminRole->givePermissionTo($permission);
            }

            return redirect()->route('admin.permission')->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create permission');
        }
    }
    public function edit($id)
    {
        // dd(Role::with('permissions')->get()->pluck('id'));

        // $roles = Role::with('permissions')->get(); 
        $roles = Role::with('permissions') 
        ->whereDoesntHave('permissions', function ($query) use ($id) {
        $query->where('id', $id);
    })->get();
        // dd($roles);
        return view("admin.permission.addpermission", compact("roles"));
    }
    public function update(Request $request, $id)
    {
        try{
        Permission::where('id', $id)
            ->update([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

        return redirect()->route("admin.permission")->with("success","permission updated successfully");
        }catch(\Exception $e){
            return redirect()->route("admin.permission")->with("error", $e->getMessage());
        }
    }
    public function delete($id)
    {
        try{
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route("admin.permission")->with("success","permission deleted successfully");
        }catch(\Exception $e){
            return redirect()->route("admin.permission")->with("error", "Something went wrong");
        }
    }

    public function giveRole(Request $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            
            if (!$request->has('role')) {
                return back()->with("error", "Role not specified");
            }

            if ($permission->hasRole($request->role)) {
                return back()->with("error", "Role exists already for this permission");
            }

            $permission->assignRole($request->role);
            return back()->with("success", "Role assigned successfully to permission");
        } catch (\Exception $e) {
            return back()->with("error", "Failed to assign role: " . $e->getMessage());
        }
    }

    public function revokeRole($permissionId, $role)
    {
        try {
            $permission = Permission::findOrFail($permissionId);
            
            if (!$permission->hasRole($role)) {
                return back()->with("error", "Role does not exist for this permission");
            }
            
            $permission->removeRole($role);
            return back()->with("success", "Role removed successfully from permission");
        } catch (\Exception $e) {   
            return back()->with("error", "Failed to remove role: " . $e->getMessage());
        }
    }
}
