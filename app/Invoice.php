<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'inv_num',
        'date',
        'customer',
        'cust_rel',
        'po_num',
        'line_items',
        'misc_char',
        'ship_fee',
        'total',
        'cartons',
        'weight',
        'complete',
        'appv_num',
        'supl_num',
        'carrier',
        'memo'
    ];
    protected $casts = [
        'customer' => 'object',
        'line_items' => 'object'
    ];
}
