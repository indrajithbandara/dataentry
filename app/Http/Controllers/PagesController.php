<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users() 
    {
        if( $this->authorize('admin') ){
            return view('page');
        }
    }
}
/*
As of right now, I'm trying to get the application to off load the gate logic to the 
*/
