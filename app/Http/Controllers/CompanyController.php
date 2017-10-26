<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
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

    /*
    * Get the one company for displaying
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
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50|max:50',
            'address' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'fax' => 'string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'desc' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'invoice_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'shipper_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'router_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'po_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50'
        ]);
        return Company::create([
            'name' => $request->input(['name']),
            'address' => $request->input(['address']),
            'phone' => $request->input(['phone']),
            'fax' => $request->input(['fax']),
            'desc' => $request->input(['desc']),
            'invoice_con' => $request->input(['invoice_con']),
            'shipper_con' => $request->input(['shipper_con']),
            'router_con' => $request->input(['router_con']),
            'po_con' => $request->input(['po_con'])
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
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50|max:50',
            'address' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\#\:\.\s]+(?<!-)$/i|max:255',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'fax' => 'string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'desc' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'invoice_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'shipper_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'router_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50',
            'po_con' => 'string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:50'
        ]);

        Company::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'address' => $request->input(['address']),
            'phone' => $request->input(['phone']),
            'fax' => $request->input(['fax']),
            'desc' => $request->input(['desc']),
            'invoice_con' => $request->input(['invoice_con']),
            'shipper_con' => $request->input(['shipper_con']),
            'router_con' => $request->input(['router_con']),
            'po_con' => $request->input(['po_con'])
        ]);
    }
}
