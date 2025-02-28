<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '51999999999',
            'identification' => $this->faker->unique()->numerify('###########'),
            'address_id' => Address::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            $role = Role::factory()->create();
            $customer->roles()->attach($role);
        });
    }
}
