<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return Company::findOrFail($id);
    }

    /**
    * Get the one company for displaying
    *
    * @return mixed
    */
    public function getName(){
        return Company::where('id', 1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCompany(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'address' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'email' => 'required|string|email|max:50',
            'desc' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'invoice_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'shipper_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'router_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'po_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'inv_prefix' => 'required|string|alpha_num|max:15'
        ]);
        return Company::create([
            'name' => $request->input(['name']),
            'address' => $request->input(['address']),
            'phone' => $request->input(['phone']),
            'email' => $request->input(['email']),
            'desc' => $request->input(['desc']),
            'invoice_con' => $request->input(['invoice_con']),
            'shipper_con' => $request->input(['shipper_con']),
            'router_con' => $request->input(['router_con']),
            'po_con' => $request->input(['po_con']),
            'inv_prefix' => $request->input(['inv_prefix'])
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function updateCompany(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'address' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'email' => 'required|string|email|max:50',
            'desc' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'invoice_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'shipper_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'router_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'po_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'inv_prefix' => 'required|string|alpha_num|max:15'
        ]);

        Company::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'address' => $request->input(['address']),
            'phone' => $request->input(['phone']),
            'email' => $request->input(['email']),
            'desc' => $request->input(['desc']),
            'invoice_con' => $request->input(['invoice_con']),
            'shipper_con' => $request->input(['shipper_con']),
            'router_con' => $request->input(['router_con']),
            'po_con' => $request->input(['po_con']),
            'inv_prefix' => $request->input(['inv_prefix'])
        ]);
    }

    /**
    * Get the invoice prefix number
    *
    * @return string
    */
    public function getInvPrefix()
    {
        // Get the values in the Databse
        $prefix = DB::table('companies')
                    ->select('inv_prefix')
                    ->get();
        $inv_num = DB::table('invoices')
                    ->select('inv_num')
                    ->orderBy('inv_num', 'desc')
                    ->limit(1)
                    ->get();
        // Check if inv_num returned a value
        if(count($inv_num) > 0){
            // Set the values to Strings
            $str_prefix = strval($prefix[0]->inv_prefix);
            $str_inv_num = strval($inv_num[0]->inv_num);
            // Check if the given prefix matches the last inv_num prefix
            // if there are matches, return the value of the inv_num with the
            // same prefix plus one.
            preg_match('/'.$str_prefix.'/', $str_inv_num, $matches);
            if(count($matches) > 0){
                return $inv_num[0]->inv_num + 1;
            }else{
                return $prefix[0]->inv_prefix . '0000';
            }
        }
        return $prefix[0]->inv_prefix . '0000';
    }
}
