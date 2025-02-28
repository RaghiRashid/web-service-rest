<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomer();

        return response()->json([
            'message' => 'Lista de clientes recuperada com sucesso.',
            'data' => $customers
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'identification' => preg_replace('/\D/', '', $request->identification),
                'phone' => preg_replace('/\D/', '', $request->phone)
            ]);

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:customers',
                'phone' => 'required|string',
                'identification' => 'required|string|unique:customers',
                'permission' => 'required|exists:roles,id',
                'street' => 'required|string',
                'number' => 'required|string',
                'district' => 'required|min:6',
                'complement' => 'required|string',
                'zip_code' => 'required|string'
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.unique' => 'Este email já está em uso.',
                'phone.required' => 'O campo telefone é obrigatório.',
                'identification.required' => 'O campo CPF é obrigatório.',
                'identification.unique' => 'Este CPF já está em uso.',
                'permission.required' => 'O campo permissão é obrigatório.',
                'permission.exists' => 'A permissão selecionada é inválida.',
                'street.required' => 'O campo rua é obrigatório.',
                'number.required' => 'O campo número é obrigatório.',
                'district.required' => 'O campo bairro é obrigatório.',
                'district.min' => 'O campo bairro deve ter pelo menos 6 caracteres.',
                'complement.required' => 'O campo complemento é obrigatório.',
                'zip_code.required' => 'O campo CEP é obrigatório.'
            ]);

            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'data' => $this->customerService->createCustomer($validatedData)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->has('identification')) {
                $request->merge([
                    'identification' => preg_replace('/\D/', '', $request->identification)
                ]);
            }

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string',
                'email' => 'sometimes|required|email|unique:customers,email,' . $id,
                'phone' => 'sometimes|required|string',
                'identification' => 'sometimes|required|string|unique:customers,identification,' . $id,
                'permission' => 'sometimes|required|exists:roles,id',
                'street' => 'sometimes|required|string',
                'number' => 'sometimes|required|string',
                'district' => 'sometimes|required|min:6',
                'complement' => 'sometimes|required|string',
                'zip_code' => 'sometimes|required|string'
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'O campo email deve ser um endereço de email válido.',
                'email.unique' => 'Este email já está em uso.',
                'phone.required' => 'O campo telefone é obrigatório.',
                'identification.required' => 'O campo CPF é obrigatório.',
                'identification.unique' => 'Este CPF já está em uso.',
                'permission.required' => 'O campo permissão é obrigatório.',
                'permission.exists' => 'A permissão selecionada é inválida.',
                'street.required' => 'O campo rua é obrigatório.',
                'number.required' => 'O campo número é obrigatório.',
                'district.required' => 'O campo bairro é obrigatório.',
                'district.min' => 'O campo bairro deve ter pelo menos 6 caracteres.',
                'complement.required' => 'O campo complemento é obrigatório.',
                'zip_code.required' => 'O campo CEP é obrigatório.'
            ]);

            return response()->json([
                'data' => $this->customerService->updateCustomer($id, $validatedData)
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        return response()->json([
            'message' => 'Cliente encontrado com sucesso.',
            'data' => $customer
        ], 200);
    }

    public function destroy($id)
    {
        return $this->customerService->deleteCustomer($id);
    }
}
