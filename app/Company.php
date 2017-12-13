<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'desc',
        'invoice_con',
        'shipper_con',
        'router_con',
        'po_con',
        'inv_prefix'
    ];
}
