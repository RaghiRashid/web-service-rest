<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->userService->authenticate($credentials);

        if (!$token) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json(['token' => $token, 'message' => 'Login realizado com sucesso'], 200);
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.unique' => 'Este email já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'O campo senha deve ter pelo menos 6 caracteres.',
            ]);

            return $this->userService->createUser($validatedData);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();

        return response()->json([
            'message' => 'Lista de clientes recuperada com sucesso.',
            'data' => $users
        ], 200);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json([
            'message' => 'Usuário encontrado com sucesso.',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email',
                'password' => 'sometimes|string|min:6',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.unique' => 'Este email já está em uso.',
                'password.required' => 'O campo senha é obrigatório.',
                'password.min' => 'O campo senha deve ter pelo menos 6 caracteres.',
            ]);

            return response()->json([
                'data' => $this->userService->updateUser($id, $validatedData)
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json(['message' => 'Usuário deletado com sucesso.'], 204);
    }
}
