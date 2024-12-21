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
