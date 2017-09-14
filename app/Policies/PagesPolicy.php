<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagesPolicy
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


    /** Level One Permissions
    *   
    *   Restrictions: None
    *
    *   Permissions:    Users [view, add, edit, delete]
    *                   Customers [view, add, edit, delete]
    *                   Products [view, add, edit, delete]
    *                   Purchaseorders [view, add, edit, delete, print]
    *                   Invoices [view, add, edit, delete, print]
    *                   Routers [view, add, edit, delete, print]
    *                   Inventory [view, add, edit, delete, print]
    */
    public function admin($user)
    {
        return $user->permission == 1 ? true : false ;
    }

    /** Level Two Permissions
    *   
    *   Restrictions: Users [view, add, edit, delete]
    *
    *   Permissions:    Customers [view, add, edit, delete]
    *                   Products [view, add, edit, delete]
    *                   Purchaseorders [view, add, edit, delete, print]
    *                   Invoices [view, add, edit, delete, print]
    *                   Routers [view, add, edit, delete, print]
    *                   Inventory [view, add, edit, delete, print]
    */
    public function admin_two($user)
    {
        return $user->permission == 2 ? true : false ;
    }

    /** Level Three Permissions
    *   
    *   Restrictions:   Users [view, add, edit, delete]
    *                   Invoices [view, add, edit, delete, print]
    *                   Customers [view, add, edit, delete]
    *                   Purchaseorders [view, add, edit, delete, print]
    *
    *   Permissions:    Products [view, add, edit, delete]
    *                   Routers [view, add, edit, delete, print]
    *                   Inventory [view, add, edit, delete, print]
    */
    public function manage_three($user)
    {
        return $user->permission == 3 ? true : false ;
    }

    /** Level Four Permissions
    *   
    *   Restrictions:   Users [view, add, edit, delete]
    *                   Invoices [view, add, edit, delete, print]
    *                   Customers [view, add, edit, delete]
    *                   Purchaseorders [view, add, edit, delete, print]
    *                   Products [view, add, edit, delete]
    *                   Inventory [view, add, edit, delete, print]
    *
    *   Permissions:    Routers [view, add, edit, delete, print]

    */
    public function empl_four($user)
    {
        return $user->permission == 4 ? true : false ;
    }
}
