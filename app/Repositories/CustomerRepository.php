<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        $customers = Customer::with(['address', 'roles'])->get();

        return response()->json($customers, 200);
    }

    public function find($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json($customer->load(['address', 'roles']), 200);
        }

        return response()->json(['message' => 'Cliente não encontrado.'], 404);
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

        $customer->roles()->attach($data['permission']);

        $roleName = $customer->roles()->first()->name;

        return response()->json([
            'customer' => $customer,
            'role' => $roleName,
            'address' => $address
        ], 201);
    }

    public function update($id, array $data)
    {
        $customer = Customer::findOrFail($id);

        $address = $customer->address;

        $address->update([
            'street' => $data['street'],
            'number' => $data['number'],
            'district' => $data['district'],
            'complement' => $data['complement'],
            'zip_code' => str_replace(['.', '-'], '', $data['zip_code']),
        ]);

        $customer->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'identification' => str_replace(['.', '-'], '', $data['identification']),
        ]);

        $customer->roles()->sync($data['permission']);

        $roleName = $customer->roles()->first()->name;

        return response()->json([
            'customer' => $customer,
            'role' => $roleName,
            'address' => $address
        ], 200);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->roles()->detach();
            $customer->delete();
            return response()->json(['message' => 'Cliente deletado com sucesso.'], 200);
        }

        return response()->json(['message' => 'Cliente não encontrado.'], 404);
    }
}
