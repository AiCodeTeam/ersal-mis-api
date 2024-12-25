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
        
        $validatedData = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create(['name' => $validatedData['name']]);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'data' => $role,
        ], 201);
    }

    /**
     * Create a new permission.
     */
    // public function createPermission(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|unique:permissions,name',
    //     ]);

    //     $permission = Permission::create(['name' => $validatedData['name']]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Permission created successfully.',
    //         'data' => $permission,
    //     ], 201);
    // }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissionsToRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findByName($validatedData['role']);
        $role->syncPermissions($validatedData['permissions']);

        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned to role successfully.',
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

    public function listRoles()
    {
        $roles = Role::with('permissions')->get();

        return response()->json([
            'success' => true,
            'message' => 'Roles retrieved successfully.',
            'data' => $roles,
        ], 200);
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
