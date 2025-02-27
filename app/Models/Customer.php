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
}
