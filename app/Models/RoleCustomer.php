<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleCustomer extends Model
{
    use HasFactory;

    protected $table = 'role_customer';

    protected $fillable = [
        'customer_id',
        'role_id'
    ];
}
