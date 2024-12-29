<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Create a new role.
     */
    public function createRole(Request $request)
    {  
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);
    
        // Create the role
        $role = Role::create(['name' => $validatedData['name']]);
    
        // If permissions are provided, assign them to the role
        if (!empty($validatedData['permissions'])) {
            // Fetch permissions by their IDs
            $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
            $role->syncPermissions($permissions);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 201);
    }
    public function updateRole(Request $request, $id)
    {
        
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'sometimes|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);
    
        // Find the role by ID
        $role = Role::find($id);
    
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }
    
        // Update the role name
        $role->update(['name' => $validatedData['name']]);
    
        // If permissions are provided, update the role's permissions
        if (!empty($validatedData['permissions'])) {
            // Fetch permissions by their IDs
            $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
            $role->syncPermissions($permissions);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'data' => $role,
        ], 200);
    }
    public function deleteRole($id)
    {
        // Find the role by ID
        $role = Role::find($id);
    
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }
    
        // Delete the role
        $role->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ], 200);
    }

    /**
     * Assign a role to a user.
     */
    public function assignRoleToUser(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($validatedData['user_id']);
        $user->assignRole($validatedData['role']);

        return response()->json([
            'success' => true,
            'message' => 'Role assigned to user successfully.',
        ], 200);
    }

    /**
     * Revoke a specific role from a user.
     */
    public function revokeRoleFromUser(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($validatedData['user_id']);
        $user->removeRole($validatedData['role']);

        return response()->json([
            'success' => true,
            'message' => 'Role revoked from user successfully.',
        ], 200);
    }

    /**
     * Revoke specific permissions from a role.
     */
    public function revokePermissionsFromRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findByName($validatedData['role']);
        $role->revokePermissionTo($validatedData['permissions']);

        return response()->json([
            'success' => true,
            'message' => 'Permissions revoked from role successfully.',
        ], 200);
    }

    /**
     * Revoke all roles from a user.
     */
    public function revokeAllRolesFromUser(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validatedData['user_id']);
        $user->roles()->detach();

        return response()->json([
            'success' => true,
            'message' => 'All roles revoked from user successfully.',
        ], 200);
    }

    /**
     * Revoke all permissions from a role.
     */
    public function revokeAllPermissionsFromRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $role = Role::findByName($validatedData['role']);
        $role->permissions()->detach();

        return response()->json([
            'success' => true,
            'message' => 'All permissions revoked from role successfully.',
        ], 200);
    }

    public function listRoles(Request $request)
    {

        if (!$request->limit) return Role::all();
        return Role::with('permissions')->paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    public function showRole($id)
    {
        return Role::with('permissions')->find($id);
    }


    /**
     * List all permissions.
     */
    public function listPermissions()
    {
        $permissions = Permission::all();

        return response()->json([
            'success' => true,
            'message' => 'Permissions retrieved successfully.',
            'data' => $permissions,
        ], 200);
    }
}
