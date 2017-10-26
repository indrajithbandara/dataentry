<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
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
    public function getInvoices()
    {
        return Invoice::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return Invoice::findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addInvoice(Request $request)
    {
        // Validate the Request
        $this->validate($request, [
            'inv_num' => 'required|numeric',
            'date' => 'required|date',
            'customer' => 'required|array', // array of customer info
            'po_num' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:30',
            'line_items' => 'required|array', // array of line items
            'ship_fee' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        return Invoice::create([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            'customer' => json_encode($request->input(['customer'])), // array of customer info
            'po_num' => $request->input(['po_num']),
            'line_items' => json_encode($request->input(['line_items'])), // arry of line items
            'ship_fee' => $request->input(['ship_fee']),
            'total' => $request->input(['total']),
            'memo' => $request->input(['memo'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function updateInvoice(Request $request, $id)
    {
        // Validate the Request
        $this->validate($request, [
            'inv_num' => 'required|numeric',
            'date' => 'required|date',
            'customer' => 'required|array', // array of customer info
            'po_num' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:30',
            'line_items' => 'required|array', // array of line items
            'ship_fee' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        Invoice::findOrFail($id)->update([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            'customer' => json_encode($request->input(['customer'])), // array of customer info
            'po_num' => $request->input(['po_num']),
            'line_items' => json_encode($request->input(['line_items'])), // arry of line items
            'ship_fee' => $request->input(['ship_fee']),
            'total' => $request->input(['total']),
            'memo' => $request->input(['memo'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteInvoice($id)
    {
        // $this->authorize('delete', $id);
        return Invoice::destroy($id);
    }
}

