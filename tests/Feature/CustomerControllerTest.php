<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);

        Role::factory()->create(['id' => 1, 'name' => 'Colaborador']);
    }

    public function testUnauthenticatedUserCannotAccessCustomerEndpoints()
    {
        $response = $this->getJson('/api/customers');
        $response->assertStatus(401);
    }

    public function testAuthenticatedUserCanGetAllCustomers()
    {
        $response = $this->getJson('/api/customers', ['Authorization' => "Bearer {$this->token}"]);
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserCanCreateCustomer()
    {
        $customerData = [
            "name" => "Zezinho",
            "email" => "zezinho.silva@example.com",
            "phone" => "51912345678",
            "identification" => "113.426.289-00",
            "permission" => "1",
            "street" => "Alberto Bins",
            "number" => "8",
            "district" => "Centro",
            "complement" => "Apto 101",
            "zip_code" => "01000000"
        ];

        $response = $this->postJson('/api/customers', $customerData, ['Authorization' => "Bearer {$this->token}"]);
        $response->assertStatus(201);
    }

    public function testAuthenticatedUserCanUpdateCustomer()
    {
        $customer = Customer::factory()->create();

        $updateData = [
            'name' => 'teste2',
            'email' => 'teste2@gmail.com'
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $updateData, ['Authorization' => "Bearer {$this->token}"]);
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserCanDeleteCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}", [], ['Authorization' => "Bearer {$this->token}"]);
        $response->assertStatus(204);
    }
}
