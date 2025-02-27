<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function getAllUsers();
    public function createUser(array $data);
    public function getUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function authenticate(array $credentials);
}
