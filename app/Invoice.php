<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'inv_num', // int(11)
        'date', // date
        'customer', // varchar(500)
        'po_num', // varchar(30)
        'line_items', // varchar(255)
        'ship_fee', // deciaml(7,2)
        'total', // decimal(7,2)
        'memo' // varchar(255)
    ];
    protected $casts = [
        'customer' => 'object',
        'line_items' => 'object'
    ];
}
