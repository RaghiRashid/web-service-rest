<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CustomerServiceInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return response()->json($this->customerService->getAllCustomer());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|string',
            'identification' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
            'district' => 'required|min:6',
            'complement' => 'required|string',
            'zip_code' => 'required|string'
        ]);

        return response()->json($this->customerService->createCustomer($validatedData));
    }

    public function show($id)
    {
        return response()->json($this->customerService->getCustomerById($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->customerService->updateCustomer($id, $request->all()));
    }

    public function destroy($id)
    {
        return response()->json($this->customerService->deleteCustomer($id));
    }
}
