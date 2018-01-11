<?php

namespace App\Http\Controllers;

use App\User;
use App\Purchaseorder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseordersController extends Controller
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
    * Get the Number of Purchaseorders
    *
    * @return mixed
    */
    public function count()
    {
        $count = Purchaseorder::all();
        return $count->count();
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getPurchaseorders()
    {
        $purchaseorders = DB::table('purchaseorders')
                            ->select(
                                'po_num',
                                'due_date',
                                'will_ship',
                                'rating',
                                'sooner',
                                'customer',
                                'part_num',
                                'qty',
                                'status',
                                'notes',
                                'placement'
                            )
                            ->orderBy('due_date', 'desc')
                            ->get();
        return $purchaseorders;
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Purchaseorder  $id
    * @return \Illuminate\Http\Response
    */
    public function getOne($id)
    {
        return Purchaseorder::findOrFail($id);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function addPurchaseorder(Request $request)
    {
        // Validate the Request
        $this->validate($request, [
            'po_num' => 'required|string|max:50',
            'due_date' => 'required|date',
            'will_ship' => 'required|date',
            'rating' => 'nullable|numeric',
            'sooner' => 'required|string',
            'customer' => 'required|string|max:100',
            'part_num' => 'required|string|max:50',
            'qty' => 'required|numeric',
            'status' => 'required|string',
            'notes' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'placement' => 'nullable|numeric'
        ]);

        // Create Purchaseorder Entry
        return Purchaseorder::create([
            'po_num' => $request->input(['po_num']),
            'due_date' => $request->input(['due_date']),
            'will_ship' => $request->input(['will_ship']),
            'rating' => $request->input(['rating']),
            'sooner' => $request->input(['sooner']),
            'customer' => $request->input(['customer']),
            'part_num' => $request->input(['part_num']),
            'qty' => $request->input(['qty']),
            'status' => $request->input(['status']),
            'notes' => $request->input(['notes']),
            'placement' => $request->input(['placement'])
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Purchaseorder  $id
    * @return \Illuminate\Http\Response
    */
    public function updatePurchaseorder(Request $request, $id)
    {
        // Validate the Request
        $this->validate($request, [
            'po_num' => 'required|string|max:50',
            'due_date' => 'required|date',
            'will_ship' => 'required|date',
            'rating' => 'nullable|numeric',
            'sooner' => 'required|string',
            'customer' => 'required|string|max:100',
            'part_num' => 'required|string|max:50',
            'qty' => 'required|numeric',
            'status' => 'required|string',
            'notes' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'placement' => 'nullable|numeric'
        ]);

        // Create Update Entry
        Purchaseorder::findOrFail($id)->update([
            'po_num' => $request->input(['po_num']),
            'due_date' => $request->input(['due_date']),
            'will_ship' => $request->input(['will_ship']),
            'rating' => $request->input(['rating']),
            'sooner' => $request->input(['sooner']),
            'customer' => $request->input(['customer']),
            'part_num' => $request->input(['part_num']),
            'qty' => $request->input(['qty']),
            'status' => $request->input(['status']),
            'notes' => $request->input(['notes']),
            'placement' => $request->input(['placement'])
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Purchaseorder  $id
    * @return \Illuminate\Http\Response
    */
    public function deletePurchaseorder($id)
    {
        $this->authorize('delete', $id);
        return Purchaseorder::destroy($id);
    }

    /**
    * Get purchaseorder report data between two dates
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function betweenDates($start, $end)
    {
        //
    }

    /**
    * Seach for a purchaseorder by it's purchaseorder number
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function byPoNum($term)
    {
        $purchaseorders = DB::table('purchaseorders')
                            ->select(
                                'po_num',
                                'due_date',
                                'will_ship',
                                'rating',
                                'sooner',
                                'customer',
                                'part_num',
                                'qty',
                                'status',
                                'notes',
                                'placement'
                            )
                            ->where('po_num', $term)
                            ->get();
        return $purchaseorders;
    }

    /**
     * import an Purchaseorders Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      DB::table('purchaseorders')->truncate();
      if($request->file('imported-purchaseorders')){
                $path = $request->file('imported-purchaseorders')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'id' => $row['id'],
                    'po_num' => $row['po_num'],
                    'due_date' => $row['due_date'],
                    'will_ship' => $row['will_ship'],
                    'rating' => $row['rating'],
                    'sooner' => $row['sooner'],
                    'customer' => $row['customer'],
                    'part_num' => $row['part_num'],
                    'qty' => $row['qty'],
                    'status' => $row['status'],
                    'notes' => $row['notes'],
                    'placement' => $row['placement']
                ];
              }
          }
          if(!empty($dataArray)){
             Purchaseorder::insert($dataArray);
             return redirect('settings')->with('purchaseorders-import-status', 'Import was successful!');
           }
         }
       }
    }

    /**
     * Export purchaseorders as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
      $items = Purchaseorder::all();
      Excel::create('dataentry-purchaseorders', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export purchaseorders as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV()
    {
      $items = Purchaseorder::all();
      Excel::create('dataentry-purchaseorders', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }
}
