<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'ist_num',
        'part_num',
        'po_num',
        'customer',
        'status',
        'boxes',
        'log'
    ];
    
    protected $casts = [
        'boxes' => 'object'
    ];

    public $timestamps = false;
}
