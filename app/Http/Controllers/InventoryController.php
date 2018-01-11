<?php

namespace App\Http\Controllers;

use App\User;
use App\Inventory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
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
    public function getInventory()
    {
        $inventory = DB::table('inventory')
                            ->select(
                                'id',
                                'ist_num',
                                'part_num',
                                'po_num',
                                'customer',
                                'status',
                                'boxes',
                                'log',
                                'date'
                            )
                            ->orderBy('date', 'desc')
                            ->get();
        return $inventory;
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Inventory  $id
    * @return \Illuminate\Http\Response
    */
    public function getOne($id)
    {
        return Inventory::findOrFail($id);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function addInventory(Request $request)
    {
        // Validate the Request
        $this->validate($request, [
            'ist_num' => 'numeric',
            'part_num' => 'nullable|string|max:50',
            'po_num' => 'nullable|string|max:50',
            'customer' => 'nullable|string|max:100',
            'status' => 'required|string',
            'boxes' => 'nullable|array',
            'log' => 'nullable|string',
            'date' => 'required|date'
        ]);

        // Create Inventory Entry
        return Inventory::create([
            'ist_num' => $request->input(['ist_num']),
            'part_num' => $request->input(['part_num']),
            'po_num' => $request->input(['po_num']),
            'customer' => $request->input(['customer']),
            'status' => $request->input(['status']),
            'boxes' => $request->input(['boxes']),
            'log' => $request->input(['log']),
            'date' => $request->input(['date'])
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Inventory  $id
    * @return \Illuminate\Http\Response
    */
    public function updateInventory(Request $request, $id)
    {
        // Validate the Request
        $this->validate($request, [
            'ist_num' => 'numeric',
            'part_num' => 'nullable|string|max:50',
            'po_num' => 'nullable|string|max:50',
            'customer' => 'nullable|string|max:100',
            'status' => 'required|string',
            'boxes' => 'nullable|array',
            'log' => 'nullable|string',
            'date' => 'required|date'
        ]);

        // Create Update Entry
        Inventory::findOrFail($id)->update([
            'ist_num' => $request->input(['ist_num']),
            'part_num' => $request->input(['part_num']),
            'po_num' => $request->input(['po_num']),
            'customer' => $request->input(['customer']),
            'status' => $request->input(['status']),
            'boxes' => $request->input(['boxes']),
            'log' => $request->input(['log']),
            'date' => $request->input(['date'])
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Inventory  $id
    * @return \Illuminate\Http\Response
    */
    public function deleteInventory($id)
    {
        $this->authorize('delete', $id);
        return Inventory::destroy($id);
    }

    /**
    * Get inventory report data between two dates
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function betweenDates($start, $end)
    {
        $inventory = DB::table('inventory')
                            ->select(
                                'ist_num',
                                'part_num',
                                'po_num',
                                'customer',
                                'status',
                                'boxes',
                                'log',
                                'date'
                            )
                            ->whereBetween('date', [$start, $end])
                            ->get();
        return $inventory;
    }

    /**
    * Seach for an inventory by it's IST number
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function byIstNum($term)
    {
        $inventory = DB::table('inventory')
                            ->select(
                                'ist_num',
                                'part_num',
                                'po_num',
                                'customer',
                                'status',
                                'boxes',
                                'log',
                                'date'
                            )
                            ->where('ist_num', $term)
                            ->get();
        return $inventory;
    }

    /**
     * import an Inventory Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      DB::table('inventory')->truncate();
      if($request->file('imported-inventory')){
                $path = $request->file('imported-inventory')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'ist_num' => $row['ist_num'],
                    'part_num' => $row['part_num'],
                    'po_num' => $row['po_num'],
                    'customer' => $row['customer'],
                    'status' => $row['status'],
                    'boxes' => $row['boxes'],
                    'log' => $row['log'],
                    'date' => $row['date']
                ];
              }
          }
          if(!empty($dataArray)){
             Inventory::insert($dataArray);
             return redirect('settings')->with('inventory-import-status', 'Import was successful!');
           }
         }
       }
    }

    /**
     * Export Inventory as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
      $items = Inventory::all();
      Excel::create('dataentry-inventory', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export Inventory as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV()
    {
      $items = Inventory::all();
      Excel::create('dataentry-inventory', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }
}
