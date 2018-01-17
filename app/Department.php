<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'dept_name',
        'dept_bg_color',
        'dept_txt_color',
        'key'
    ];

    public $timestamps = false;
}