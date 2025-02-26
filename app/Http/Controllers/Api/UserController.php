<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getAllUsers());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        return response()->json($this->userService->createUser($data));
    }

    public function show($id)
    {
        return response()->json($this->userService->getUserById($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->userService->updateUser($id, $request->all()));
    }

    public function destroy($id)
    {
        return response()->json($this->userService->deleteUser($id));
    }
}
