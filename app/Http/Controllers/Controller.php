<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Double Decode Decoded JSON Data For PDF Class
    *
    * @param $val  Double Encoded String
    * @return Double Decoded String
    */
    public function doubleDecode($val){
        while(gettype($val) == 'string'){
            $val = json_decode($val, true);
        }
        return $val;
    }
}
