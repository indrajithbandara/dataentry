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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getUsers()
    {
        return User::all();
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\User  $id
    * @return \Illuminate\Http\Response
    */
    public function getUser($id)
    {
        return User::findOrFail($id);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
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

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\User  $id
    * @return \Illuminate\Http\Response
    */
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

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $id
    * @return \Illuminate\Http\Response
    */
    public function deleteUser($id)
    {
        $this->authorize('delete', $id);
        return User::destroy($id);
    }
}
