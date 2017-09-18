<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isSuperAdmin() 
    {
        return Auth::user()->permission == 1;
    }

    public static function isAdmin()
    {
        return Auth::user()->permission == 2;
    }

    public static function isManager()
    {
        return Auth::user()->permission == 3;
    }

    public static function isEmployee()
    {
        return Auth::user()->permission == 4;
    }
}
