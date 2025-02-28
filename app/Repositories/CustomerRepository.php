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
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Cliente não encontrado.'], 404);
        }

        $address = $customer->address;

        $address->update([
            'street' => $data['street'] ?? $address->street,
            'number' => $data['number'] ?? $address->number,
            'district' => $data['district'] ?? $address->district,
            'complement' => $data['complement'] ?? $address->complement,
            'zip_code' => isset($data['zip_code']) ? str_replace(['.', '-'], '', $data['zip_code']) : $address->zip_code,
        ]);

        $customer->update([
            'name' => $data['name'] ?? $customer->name,
            'email' => $data['email'] ?? $customer->email,
            'phone' => $data['phone'] ?? $customer->phone,
            'identification' => isset($data['identification']) ? str_replace(['.', '-'], '', $data['identification']) : $customer->identification,
        ]);

        if (!empty($data['permission'])) {
            $customer->roles()->sync($data['permission']);
        }

        return response()->json([
            'customer' => $customer->load(['address', 'roles'])
        ], 200);
    }


    public function delete($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->roles()->detach();
            $customer->delete();
            return response()->json(['message' => 'Cliente deletado com sucesso.'], 204);
        }

        return response()->json(['message' => 'Não foi possível encontrar o cliente.'], 404);
    }
}
