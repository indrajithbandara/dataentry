<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'shipto',
        'billto',
        'buyer',
        'email',
        'phone',
        'country',
        'disclaimer',
        'comments'
    ];
}
