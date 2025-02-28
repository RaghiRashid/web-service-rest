<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;
    protected $userRepository;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepositoryInterface::class);
        $this->userService = $this->app->make(UserServiceInterface::class);

        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function testRegister()
    {
        $data = [
            'name' => 'teste',
            'email' => 'teste@gmail.com',
            'password' => 'senha123'
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                'token',
                'token_type'
            ]);
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'teste@gmail.com',
            'password' => Hash::make('senha123')
        ]);

        $credentials = ['email' => 'teste@gmail.com', 'password' => 'senha123'];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'message']);
    }

    public function testGetAllUsers()
    {
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users', ['Authorization' => "Bearer {$this->token}"]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => ['id', 'name', 'email', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function testGetUserById()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}", ['Authorization' => "Bearer {$this->token}"]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at']
            ]);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/users/{$user->id}", $data, ['Authorization' => "Bearer {$this->token}"]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Usuário atualizado com sucesso!',
                'data' => ['id' => $user->id, 'name' => 'Updated Name']
            ]);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}", [], ['Authorization' => "Bearer {$this->token}"]);

        $response->assertStatus(204);
    }
}
