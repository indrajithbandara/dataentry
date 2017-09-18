<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Only Admin level one has permission to delete users
    public function deleteUser($user)
    {
        return $user->permission == 1 ? true : false ;
    }
}
