<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'address2',
        'district',
        'city',
        'country',
        'zipcode',
        'phone',
        'email',
        'logo',
    ];
    public $timestamps = false;
}
