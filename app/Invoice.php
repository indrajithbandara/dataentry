<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'inv_num',
        'date',
        // Copy of the customer in the customers table
        'customer',
        'name',
        'shipto',
        'billto',
        'buyer',
        'email',
        'phone',
        'country',
        'disclaimer',
        'comments',
        // End of customer copy
        'po_num',
        // Start of line item enries x 7
        // ========================== One
        'li_one',
        'product_one',
        'qty_one',
        'unit_one',
        'extended_one',
        //=========================== Two
        'li_two',
        'product_two'
        'qty_two',
        'unit_two',
        'extended_two',
        // ========================= Three
        'li_three',
        'product_three',
        'qty_three',
        'unit_three',
        'extended_three',
        // ========================= Four
        'li_four',
        'product_four',
        'qty_four',
        'unit_four',
        'extended_four',
        // ========================= Five
        'li_five',
        'product_five',
        'qty_five',
        'unit_five',
        'extended_five',
        // ========================= Six
        'li_six',
        'product_six',
        'qty_six',
        'unit_six',
        'extended_six',
        // ========================== Seven
        'li_seven',
        'product_seven',
        'qty_seven',
        'unit_seven',
        'extended_seven',
        // End of line item entries
        'ship_fee',
        'total',
        'memo'
    ];
}
