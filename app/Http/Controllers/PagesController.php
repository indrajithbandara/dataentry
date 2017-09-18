<?php

namespace App\Http\Controllers;

use App\User;
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

    public function invoices()
    {
        if( User::isSuperAdmin() || User::isAdmin() ) {
            return view('page');
        }else{
            return abort('401');
        }
    }

    public function users()
    {
        if( User::isSuperAdmin() ) { 
            return view('page'); 
        }else{
            return abort('401');
        }
    }

    public function customers() 
    {
        if( User::isSuperAdmin() || User::isAdmin() ) {
            return view('page');
        }else{
            return abort('401');
        }
    }

    public function products()
    {
        if( User::isSuperAdmin() || User::isAdmin() || User::isManager() ) {
            return view('page');
        }else{
            return abort('401');
        }
    }
}
