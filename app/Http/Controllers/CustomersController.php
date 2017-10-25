<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
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
     * Display a listing of Customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomers()
    {
        return Customer::all();
    }

    /**
     * Display a single of Customers.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getCustomer($id)
    {
        return Customer::findOrFail($id);
    }

    /**
     * Store a new Customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCustomer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'shipto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'billto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'buyer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'country' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:15',
            'disclaimer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255',
            'comments' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);
        return Customer::create([
            'name' => $request->input(['name']),
            'shipto' => $request->input(['shipto']),
            'billto' => $request->input(['billto']),
            'buyer' => $request->input(['buyer']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone']),
            'country' => $request->input(['country']),
            'disclaimer' => $request->input(['disclaimer']),
            'comments' => $request->input(['comments'])
        ]);
    }

    /**
     * Update the specified customer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCustomer(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'shipto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'billto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'buyer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'country' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:15',
            'disclaimer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255',
            'comments' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);
        Customer::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'shipto' => $request->input(['shipto']),
            'billto' => $request->input(['billto']),
            'buyer' => $request->input(['buyer']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone']),
            'country' => $request->input(['country']),
            'disclaimer' => $request->input(['disclaimer']),
            'comments' => $request->input(['comments'])
        ]);
    }

    /**
     * Remove the specified customer.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomer($id)
    {
        // $this->authorize('delete', $id);
        return Customer::destroy($id);
    }
}
