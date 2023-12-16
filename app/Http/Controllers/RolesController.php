<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolesController extends Controller
{
  
    public function index(Request $request)
    {   
        $permissions = Permission::All();
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles', 'permissions'));

    }
    
    
    public function store(Request $request)
    {
      
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);
    
        // Create the role
        $role = Role::create([
            'name' => $request->input('name'),
        ]);
        // Get the selected permissions
        $permissions = $request->input('permissions');

        $data = [];
        foreach ($permissions as $permissionId) {
            $data[] = [
                'role_id' => $role->id,
                'permission_id' => $permissionId,
            ];
        }
        // Bulk insert 
        RolePermission::insert($data);
    
        return redirect()->route('roles')->with('success', 'Role created successfully');
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array',
        ]);
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->input('name'),
        ]);
        if($role){  $role->permissions()->delete();
            DB::delete("DELETE FROM role_permissions WHERE role_id = :role_id", ['role_id' => $role]);
        $permissions = $request->input('permissions');
        $data = [];
        foreach ($permissions as $permissionId) {
            $data[] = [
                'role_id' => $role->id,
                'permission_id' => $permissionId,
            ];
        }

         RolePermission::insert($data);
        }
      
        return response()->json(['message' => 'Success'], 200);
    }
    public function deleteRole(Request $request, $id)
    {
        $role = $id;
        // Log::info('role:', ['role' =>$role]);
        $roled = Role::find($role);
        if (!$roled) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $roled->delete();
        DB::delete("DELETE FROM role_permissions WHERE role_id = :role_id", ['role_id' => $role]);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}