<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
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

    // Get All Users
    public function getUsers()
    {
        return User::all();
    }

    // Get One User
    public function getUser($id)
    {
        return User::findOrFail($id);
    }

    // Add a User
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'permission' => 'required|max:1'
        ]);

        return User::create([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'password' => bcrypt($request->input(['password'])),
            'permission' => $request->input(['permission'])
        ]);
    }

    // Update User
    public function updateUser(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191',
            'permission' => 'required|max:1'
        ]);

        User::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'email' => $request->input(['email']),
            'permission' => $request->input(['permission'])
        ]);
    }

    // Delete User
    public function deleteUser($id)
    {
        $this->authorize('delete', $id);
        return User::destroy($id);
    }
}
