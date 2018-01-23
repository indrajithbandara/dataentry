<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $fillable = [
        'router_num',
        'part_num',
        'po_num',
        'customer',
        'qty',
        'stock_qty',
        'rating',
        'status',
        'dept_name',
        'move_log',
        'employee',
        'date',
        'date_in_inv',
        'key'
    ];

    public $timestamps = false;
}
