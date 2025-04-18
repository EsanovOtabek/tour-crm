<?php

namespace App\Http\Controllers\RolesAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class GivePermissionController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $selectedRole = null;
        $permissions = [];
        $permissionStates = [];
        $custom_permission = [];

        if ($request->has('role_id')) {

            DB::statement("SET SQL_MODE=''");
            $role_permission = Permission::select('name','id')->groupBy('name')->get();



            foreach($role_permission as $per){
                $key = substr($per->name, 0, strpos($per->name, "."));
                if(str_starts_with($per->name, $key)){
                    $custom_permission[$key][] = $per;
                }
            }

            // Rol va unga tegishli permissionlarni olish
            $selectedRole = Role::with('permissions')->find($request->role_id);
            $permissions = Permission::all();

            // ✅ permission_id => true/false massivini tuzish
            $rolePermissionIds = $selectedRole->permissions->pluck('id')->toArray();

            foreach ($permissions as $permission) {
                $permissionStates[$permission->id] = in_array($permission->id, $rolePermissionIds);
            }
        }

        return view('roles-and-permissions.give-permissions', compact('roles', 'selectedRole', 'permissions', 'permissionStates','custom_permission'));
    }


    public function sync(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($request->role_id);


        $permissionIds = $request->permissions ?? [];

        $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $permissionIds)->get();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.permissions.index', ['role_id' => $role->id])
            ->with('success', 'Permissions updated successfully');
    }

}
