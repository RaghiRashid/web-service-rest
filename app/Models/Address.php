<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = ['street', 'number', 'complement', 'district', 'zip_code'];

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
