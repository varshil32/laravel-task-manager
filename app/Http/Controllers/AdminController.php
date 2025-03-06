<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', ['users' => $users]);  
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        
        return view('admin.edit', compact('user', 'roles'));
    }

    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.index')->with('success','user deleted successfully');
    }
    public function revokeRole($userId, $role)
    {
        try {
            $user = User::findOrFail($userId);
            
            if (!$user->hasRole($role)) {
                return back()->with("error", "Role does not exist for this user");
            }
            
            $user->removeRole($role);
            return back()->with("success", "Role removed successfully from user");
        } catch (\Exception $e) {   
            return back()->with("error", "Failed to remove role: ". $e->getMessage());
        }
    }

    public function assignRole(Request $request, $userId)
        {
            try {
                $user = User::findOrFail($userId);
                
                if (!$request->has('role')) {
                    return back()->with("error", "Role not specified");
                }
    
                if ($user->hasRole($request->role)) {
                    return back()->with("error", "Role already assigned to user");
                }
    
                $user->assignRole($request->role);
                return back()->with("success", "Role assigned successfully");
            } catch (\Exception $e) {
                return back()->with("error", "Failed to assign role: " . $e->getMessage());
            }
        }
}
