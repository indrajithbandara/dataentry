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
            'inv_num' => 'required|numeric|max:11',
            'date' => 'required|date',
            // Copy of the customer in the customers table
            'customer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'shipto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+(?<!-)$/i|max:255',
            'billto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+(?<!-)$/i|max:255',
            'buyer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'country' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:15',
            'disclaimer' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255',
            'comments' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
            // End of customer copy
            'po_num' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\-\.\s]+(?<!-)$/i|max:30',
            // Start of line item enries x 7
            // ========================== One 
            'li_one' => 'required|string|alpha_num|max:15',
            'product_one' => 'required|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_one' => 'required|numeric|max:11',
            'unit_one' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_one' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            //=========================== Two
            'li_two' => 'nullable|string|alpha_num|max:15',
            'product_two' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_two' => 'nullable|numeric|max:11',
            'unit_two' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_two' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Three
            'li_three' => 'nullable|string|alpha_num|max:15',
            'product_three' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_three' => 'nullable|numeric|max:11',
            'unit_three' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_three' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Four
            'li_four' => 'nullable|string|alpha_num|max:15',
            'product_four' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_four' => 'nullable|numeric|max:11',
            'unit_four' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_four' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Five
            'li_five' => 'nullable|string|alpha_num|max:15',
            'product_five' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_five' => 'nullable|numeric|max:11',
            'unit_five' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_five' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Six
            'li_six' => 'nullable|string|alpha_num|max:15',
            'product_six' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_six' => 'nullable|numeric|max:11',
            'unit_six' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_six' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================== Seven
            'li_seven' => 'nullable|string|alpha_num|max:15',
            'product_seven' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_seven' => 'nullable|numeric|max:11',
            'unit_seven' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_seven' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // End of line item entries
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        return Invoice::create([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            // Copy of the customer in the customers table
            'customer' => $request->input(['customer']),
            'name' => $request->input(['name']),
            'shipto' => $request->input(['shipto']),
            'billto' => $request->input(['billto']),
            'buyer' => $request->input(['buyer']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone']),
            'country' => $request->input(['country']),
            'disclaimer' => $request->input(['disclaimer']),
            'comments' => $request->input(['comments']),
            // End of customer copy
            'po_num' => $request->input(['po_num']),
            // Start of line item enries x 7
            // ========================== One
            'li_one' => $request->input(['li_one']),
            'product_one' => $request->input(['product_one']),
            'qty_one' => $request->input(['qty_one']),
            'unit_one' => $request->input(['unit_one']),
            'extended_one' => $request->input(['extended_one']),
            //=========================== Two
            'li_two' => $request->input(['li_two']),
            'product_two' => $request->input(['product_two']),
            'qty_two' => $request->input(['qty_two']),
            'unit_two' => $request->input(['unit_two']),
            'extended_two' => $request->input(['extended_two']),
            // ========================= Three
            'li_three' => $request->input(['li_three']),
            'product_three' => $request->input(['product_three']),
            'qty_three' => $request->input(['qty_three']),
            'unit_three' => $request->input(['unit_three']),
            'extended_three' => $request->input(['extended_three']),
            // ========================= Four
            'li_four' => $request->input(['li_four']),
            'product_four' => $request->input(['product_four']),
            'qty_four' => $request->input(['qty_four']),
            'unit_four' => $request->input(['unit_four']),
            'extended_four' => $request->input(['extended_four']),
            // ========================= Five
            'li_five' => $request->input(['li_five']),
            'product_five' => $request->input(['product_five']),
            'qty_five' => $request->input(['qty_five']),
            'unit_five' => $request->input(['unit_five']),
            'extended_five' => $request->input(['extended_five']),
            // ========================= Six
            'li_six' => $request->input(['li_six']),
            'product_six' => $request->input(['product_six']),
            'qty_six' => $request->input(['qty_six']),
            'unit_six' => $request->input(['unit_six']),
            'extended_six' => $request->input(['extended_six']),
            // ========================== Seven
            'li_seven' => $request->input(['li_seven']),
            'product_seven' => $request->input(['product_seven']),
            'qty_seven' => $request->input(['qty_seven']),
            'unit_seven' => $request->input(['unit_seven']),
            'extended_seven' => $request->input(['extended_seven']),
            // End of line item entries
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
            'inv_num' => 'required|numeric|max:11',
            'date' => 'required|date',
            // Copy of the customer in the customers table
            'customer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'name' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'shipto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+(?<!-)$/i|max:255',
            'billto' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\-\.\s]+(?<!-)$/i|max:255',
            'buyer' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\.\s]+(?<!-)$/i|max:50',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|regex:/^(?!-)(?!.*--)[0-9\(\)\-\s]+(?<!-)$/i|max:25',
            'country' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:15',
            'disclaimer' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255',
            'comments' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
            // End of customer copy
            'po_num' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z\,\-\.\s]+(?<!-)$/i|max:30',
            // Start of line item enries x 7
            // ========================== One 
            'li_one' => 'required|string|alpha_num|max:15',
            'product_one' => 'required|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_one' => 'required|numeric|max:11',
            'unit_one' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_one' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            //=========================== Two
            'li_two' => 'nullable|string|alpha_num|max:15',
            'product_two' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_two' => 'nullable|numeric|max:11',
            'unit_two' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_two' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Three
            'li_three' => 'nullable|string|alpha_num|max:15',
            'product_three' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_three' => 'nullable|numeric|max:11',
            'unit_three' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_three' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Four
            'li_four' => 'nullable|string|alpha_num|max:15',
            'product_four' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_four' => 'nullable|numeric|max:11',
            'unit_four' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_four' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Five
            'li_five' => 'nullable|string|alpha_num|max:15',
            'product_five' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_five' => 'nullable|numeric|max:11',
            'unit_five' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_five' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================= Six
            'li_six' => 'nullable|string|alpha_num|max:15',
            'product_six' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_six' => 'nullable|numeric|max:11',
            'unit_six' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_six' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // ========================== Seven
            'li_seven' => 'nullable|string|alpha_num|max:15',
            'product_seven' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',,
            'qty_seven' => 'nullable|numeric|max:11',
            'unit_seven' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'extended_seven' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            // End of line item entries
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        Invoice::findOrFail($id)->update([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            // Copy of the customer in the customers table
            'customer' => $request->input(['customer']),
            'name' => $request->input(['name']),
            'shipto' => $request->input(['shipto']),
            'billto' => $request->input(['billto']),
            'buyer' => $request->input(['buyer']),
            'email' => $request->input(['email']),
            'phone' => $request->input(['phone']),
            'country' => $request->input(['country']),
            'disclaimer' => $request->input(['disclaimer']),
            'comments' => $request->input(['comments']),
            // End of customer copy
            'po_num' => $request->input(['po_num']),
            // Start of line item enries x 7
            // ========================== One
            'li_one' => $request->input(['li_one']),
            'product_one' => $request->input(['product_one']),
            'qty_one' => $request->input(['qty_one']),
            'unit_one' => $request->input(['unit_one']),
            'extended_one' => $request->input(['extended_one']),
            //=========================== Two
            'li_two' => $request->input(['li_two']),
            'product_two' => $request->input(['product_two']),
            'qty_two' => $request->input(['qty_two']),
            'unit_two' => $request->input(['unit_two']),
            'extended_two' => $request->input(['extended_two']),
            // ========================= Three
            'li_three' => $request->input(['li_three']),
            'product_three' => $request->input(['product_three']),
            'qty_three' => $request->input(['qty_three']),
            'unit_three' => $request->input(['unit_three']),
            'extended_three' => $request->input(['extended_three']),
            // ========================= Four
            'li_four' => $request->input(['li_four']),
            'product_four' => $request->input(['product_four']),
            'qty_four' => $request->input(['qty_four']),
            'unit_four' => $request->input(['unit_four']),
            'extended_four' => $request->input(['extended_four']),
            // ========================= Five
            'li_five' => $request->input(['li_five']),
            'product_five' => $request->input(['product_five']),
            'qty_five' => $request->input(['qty_five']),
            'unit_five' => $request->input(['unit_five']),
            'extended_five' => $request->input(['extended_five']),
            // ========================= Six
            'li_six' => $request->input(['li_six']),
            'product_six' => $request->input(['product_six']),
            'qty_six' => $request->input(['qty_six']),
            'unit_six' => $request->input(['unit_six']),
            'extended_six' => $request->input(['extended_six']),
            // ========================== Seven
            'li_seven' => $request->input(['li_seven']),
            'product_seven' => $request->input(['product_seven']),
            'qty_seven' => $request->input(['qty_seven']),
            'unit_seven' => $request->input(['unit_seven']),
            'extended_seven' => $request->input(['extended_seven']),
            // End of line item entries
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
        return Invoice::destory($id);
    }
}
