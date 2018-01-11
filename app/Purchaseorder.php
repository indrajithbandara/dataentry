<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    protected $fillable = [
        'po_num',
        'due_date',
        'will_ship',
        'rating',
        'sooner',
        'customer',
        'part_num',
        'qty',
        'status',
        'notes',
        'placement'
    ];

    public $timestamps = false;
}
