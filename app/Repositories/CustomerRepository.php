<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        return Customer::all();
    }

    public function find($id)
    {
        return Customer::find($id);
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function update($id, array $data)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        return Customer::destroy($id);
    }
} {
}
