<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /* 
    ROUTE - GET api/users
    DESC - fetch all users with filtering by roles
    REQUEST PARAMETER
        - roles = optional | string | sample value "2,3"
    */
    public function index(Request $request): JsonResponse
    {
        $roles = $request['roles'];
        $users = User::with('roles')->getUsersByRoles($roles)->get();

        return response()->json($users);
    }


    /* 
    ROUTE - POST api/users
    DESC - creates new user
    SAMPLE REQUEST PAYLOAD IN JSON FORMAT
        {
            "full_name": "Tony Stark",
            "email": "tonystark@email.com",
            "roles": [2,3]
        }
    */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->all());
            $user->roles()->attach($request->roles);

            return response()->json(['status' => 'success', 'message' => 'Saved Successfully', 'data' => $user]);
        } catch (\Exception $e) {
            Log::error("Error in saving user", $e->getMessage());
            return response()->json(['status' => 'error', 'message' => "Server Error. Please check the logs"]);
        }
    }
}
