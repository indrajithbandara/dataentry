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
        'status',
        'dept_name',
        'move_log',
        'date',
        'date_in_inv'
    ];

    public $timestamps = false;
}
