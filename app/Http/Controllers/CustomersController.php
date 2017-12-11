<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
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
        $customers = DB::table('customers')
                    ->select('id','name', 'email', 'phone', 'buyer', 'country')
                    ->get();
        return $customers;
    }

    /**
    * Get the Number of Customers
    */
    public function count()
    {
        $count = Customer::all();
        return $count->count();
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
        $this->authorize('delete', $id);
        return Customer::destroy($id);
    }

    /**
     * import a customers Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      if($request->file('imported-customers')){
                $path = $request->file('imported-customers')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'shipto' => $row['shipto'],
                    'billto' => $row['billto'],
                    'buyer' => $row['buyer'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'country' => $row['country'],
                    'disclaimer' => $row['disclaimer'],
                    'comments' => $row['comments'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                ];
              }
          }
          if(!empty($dataArray)){
             Customer::insert($dataArray);
             return back();
           }
         }
       }
    }

    /**
     * Export customers as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(){
      $items = Customer::all();
      Excel::create('dataentry-customers', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export customers as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(){
      $items = Customer::all();
      Excel::create('dataentry-customers', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }
}
