<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    * Get the Number of Invoices 
    *
    * @return mixed
    */
    public function count()
    {
        $count = Invoice::all();
        return $count->count();
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getInvoices()
    {
        $invoices = DB::table('invoices')
                            ->select('id','inv_num', 'date', 'customer', 'total')
                            ->orderBy('date', 'desc')
                            ->get();
        $newArr = [];
        foreach($invoices as $key => $value){
            if($key === 'customer'){
                $d_decoded;
                $counter;
                while(gettype($value) == 'string' && $counter <= 5){
                     $d_decoded = json_decode($value, true);
                     $counter++;
                }
                 array_push($newArr, $d_decoded);
            }else {
                array_push($newArr, $value);
            }
        }
        return $newArr;
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
            'customer' => 'required|array', // array of customer info3
            'po_num' => 'required|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:30',
            'line_items' => 'required|array', // array of line items
            'misc_char' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'ship_fee' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'complete' => 'nullable|string',
            'carrier' => 'nullable|string|max:50',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        return Invoice::create([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            'customer' => json_encode($request->input(['customer'])), // array of customer info
            'po_num' => $request->input(['po_num']),
            'line_items' => json_encode($request->input(['line_items'])), // arry of line items
            'misc_char' => $request->input(['misc_char']),
            'ship_fee' => $request->input(['ship_fee']),
            'total' => $request->input(['total']),
            'complete' => $request->input(['complete']),
            'carrier' => $request->input(['carrier']),
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
            'misc_char' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'ship_fee' => 'nullable|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'total' => 'required|regex:/^(?!-)(?!.*--)[0-9\.]+(?<!-)$/i',
            'complete' => 'nullable|string',
            'carrier' => 'nullable|string|max:50',
            'memo' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i|max:255'
        ]);

        // Create Invoice Entry
        Invoice::findOrFail($id)->update([
            'inv_num' => $request->input(['inv_num']),
            'date' => $request->input(['date']),
            'customer' => json_encode($request->input(['customer'])), // array of customer info
            'po_num' => $request->input(['po_num']),
            'line_items' => json_encode($request->input(['line_items'])), // arry of line items
            'misc_char' => $request->input(['misc_char']),
            'ship_fee' => $request->input(['ship_fee']),
            'total' => $request->input(['total']),
            'complete' => $request->input(['complete']),
            'carrier' => $request->input(['carrier']),
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
        $this->authorize('delete', $id);
        return Invoice::destroy($id);
    }

    /**
    * Get invoice report data between two dates
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function betweenDates($start, $end)
    {
        $invoices = DB::table('invoices')
                    ->select('id','inv_num', 'date', 'customer', 'total')
                    ->whereBetween('date', [$start, $end])
                    ->get();
        $newArr = [];
        foreach($invoices as $key => $value){
            if($key === 'customer'){
                 $d_decoded = $this->doubleDecode($value);
                 array_push($newArr, $d_decoded);
            }else {
                array_push($newArr, $value);
            }
        }
        return $newArr;
    }

    /**
    * Seach for an invoice by it's invoice number
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function byInvoiceNum($term)
    {
        $searchResult = DB::table('invoices')
                            ->select('id','inv_num', 'date', 'customer', 'total')
                            ->where('inv_num', $term)
                            ->get();
        $newArr = [];
        foreach($searchResult as $key => $value){
            if($key === 'customer'){
                 $d_decoded = $this->doubleDecode($value);
                 array_push($newArr, $d_decoded);
            }else {
                array_push($newArr, $value);
            }
        }
        return $newArr;
    }

    /**
     * import an invoices Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      DB::table('invoices')->truncate();
      if($request->file('imported-invoices')){
                $path = $request->file('imported-invoices')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'id' => $row['id'],
                    'inv_num' => $row['inv_num'],
                    'date' => $row['date'],
                    'customer' => $row['customer'],
                    'po_num' => $row['po_num'],
                    'line_items' => $row['line_items'],
                    'misc_char' => $row['misc_char'],
                    'ship_fee' => $row['ship_fee'],
                    'total' => $row['total'],
                    'complete' => $row['complete'],
                    'carrier' => $row['carrier'],
                    'memo' => $row['memo'],
                ];
              }
          }
          if(!empty($dataArray)){
             Invoice::insert($dataArray);
             return redirect('settings')->with('invoice-import-status', 'Import was successful!');
           }
         }
       }
    }

    /**
     * Export invoices as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
      $items = Invoice::all();
      Excel::create('dataentry-invoices', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export invoices as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV()
    {
      $items = Invoice::all();
      Excel::create('dataentry-invoices', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }

    /**
    * Drop data and export to file
    *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function dropAndExport()
    {
        $items = Invoice::all();
        DB::table('invoices')->truncate();
        Excel::create('dataentry-invoices', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
        })->export('csv');
    }
}