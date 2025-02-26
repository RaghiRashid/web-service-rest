<?php

namespace App\Services\Interfaces;

interface CustomerServiceInterface
{
    public function getAllCustomer();
    public function createCustomer(array $data);
    public function getCustomerById($id);
    public function updateCustomer($id, array $data);
    public function deleteCustomer($id);
}
