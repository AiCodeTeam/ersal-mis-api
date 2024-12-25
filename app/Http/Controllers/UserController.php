<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class UserController extends Controller
{
   
    public function index(Request $request){
        return User::paginate($request->limit ?? 10, ['*'], 'page', $request->page ?? 1);
    }

    public function rolesAndPermission()
    {

        return User::all();
        $users = User::find(1)->with(['roles', 'permissions'])->get();
        // return $users;
    
        $formattedUsers = $users->map(function ($user) {
            // Map each permission with model type and ID
            $permissionsWithModels = $user->getAllPermissions()->map(function ($permission) {
                return [
                    'permission' => $permission->name,
                    'model_type' => $permission->model_type ?? null, // Assuming permission has model_type column
                    'model_id' => $permission->model_id ?? null, // Assuming permission has model_id column
                ];
            });
    
            // Map each role with its name (keeping roles simple here)
            $roles = $user->roles->pluck('name');
    
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $roles, // List of roles
                'permissions' => $permissionsWithModels, // Permissions with models
            ];
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Users with roles and permissions retrieved successfully.',
            'data' => $formattedUsers,
        ], 200);
    }
    

    public function show(User $user) 
    {
        return response()->json([
            'success' => true,
            'message' => 'user retrieved successfully',
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User has been updated successfully',
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User has been deleted successfully',
            'status' => 200,
        ], 200);
    }

}
