<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
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
    public function createPermission(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $validatedData['name']]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully.',
            'data' => $permission,
        ], 201);
    }

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
}
