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
        $data = $request->validate([
            'street' => 'required|string',
            'number' => 'required|email|unique:users',
            'district' => 'required|min:6',
            'complement' => 'required|string|unique:users',
            'zip_code' => 'required|string'
        ]);

        return response()->json($this->customerService->createCustomer($data));
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
