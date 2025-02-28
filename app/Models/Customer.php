<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'identification',
        'phone',
        'address_id'
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_customer', 'customer_id', 'role_id');
    }
}
