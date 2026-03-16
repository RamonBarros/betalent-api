<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:users_roles,id', 
        ]);

        $user = $this->userService->register($data);

        return response()->json($user, 201);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'email'    => "sometimes|required|email|unique:users,email,{$id}",
            'password' => 'sometimes|nullable|string|min:8',
            'role_id'  => 'sometimes|required|exists:users_roles,id',
        ]);

        $user = $this->userService->update($id, $data);

        return response()->json($user);
    }

    public function getUserRole(Request $request)
    {

        return response()->json($request->user()->load('role'));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token deleted']);
    }
}