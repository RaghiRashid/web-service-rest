<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        return Customer::with('address')->get();
    }

    public function find($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return $customer->load('address');
        }

        return null;
    }

    public function create(array $data)
    {

        $address = Address::create([
            'street' => $data['street'],
            'number' => $data['number'],
            'district' => $data['district'],
            'complement' => $data['complement'],
            'zip_code' => str_replace(['.', '-'], '', $data['zip_code']),
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'identification' => str_replace(['.', '-'], '', $data['identification']),
            'address_id' => $address->id
        ]);

        return [
            'customer' => $customer,
            'address' => $address
        ];
    }

    public function update($id, array $data)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            return response()->json(['message' => 'Customer deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Customer not found.'], 404);
    }
}
