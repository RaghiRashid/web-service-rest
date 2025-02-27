<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

    public function configure()
    {
        return $this->afterCreating(function (Customer $customer) {
            $roles = Role::factory()->count(1)->create();
            $customer->roles()->attach($roles);
        });
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'role_customer', 'role_id', 'customer_id');
    }
}
