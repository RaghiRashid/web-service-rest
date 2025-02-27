<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Services\Interfaces\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomer()
    {
        return $this->customerRepository->all();
    }

    public function createCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->find($id);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->delete($id);
    }
}
