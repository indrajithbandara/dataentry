<?php

namespace App\Http\Controllers;

use App\User;
use App\Router;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoutersController extends Controller
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
    * Get the Number of Routers 
    *
    * @return mixed
    */
    public function count()
    {
        $count = Router::all();
        return $count->count();
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getRouters()
    {
        $routers = DB::table('routers')
                            ->select(
                                'id',
                                'router_num', 
                                'qty', 
                                'part_num', 
                                'po_num', 
                                'customer', 
                                'status', 
                                'dept_name', 
                                'date', 
                                'move_log',
                                'placement'
                            )
                            ->orderBy('date', 'desc')
                            ->get();
        return $routers;
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Router  $id
    * @return \Illuminate\Http\Response
    */
    public function getOne($id)
    {
        return Router::findOrFail($id);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function addRouter(Request $request)
    {
        // Validate the Request
        $this->validate($request, [
            'router_num' => 'required|numeric',
            'part_num' => 'required|string|max:50',
            'po_num' => 'nullable|string|max:50',
            'customer' => 'nullable|string|max:50',
            'qty' => 'required|numeric',
            'stock_qty' => 'nullable|numeric',
            'status' => 'required|string',
            'dept_name' => 'nullable|string|alpha|max:50',
            'move_log' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'date' => 'required|date',
            'date_in_inv' => 'nullable|date',
            'placement' => 'nullable|numeric'
        ]);

        // Create Router Entry
        return Router::create([
            'router_num' => $request->input(['router_num']),
            'part_num' => $request->input(['part_num']),
            'po_num' => $request->input(['po_num']),
            'customer' => $request->input(['customer']),
            'qty' => $request->input(['qty']),
            'stock_qty' => $request->input(['stock_qty']),
            'status' => $request->input(['status']),
            'dept_name' => $request->input(['dept_name']),
            'move_log' => $request->input(['move_log']),
            'date' => $request->input(['date']),
            'date_in_inv' => $request->input(['date_in_inv']),
            'placement' => $request->input(['placement'])
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Router  $id
    * @return \Illuminate\Http\Response
    */
    public function updateRouter(Request $request, $id)
    {
        // Validate the Request
        $this->validate($request, [
            'router_num' => 'required|numeric',
            'part_num' => 'required|string|max:50',
            'po_num' => 'nullable|string|max:50',
            'customer' => 'nullable|string|max:50',
            'qty' => 'required|numeric',
            'stock_qty' => 'nullable|numeric',
            'status' => 'required|string',
            'dept_name' => 'nullable|string|alpha|max:50',
            'move_log' => 'nullable|string|regex:/^(?!-)(?!.*--)[A-Za-z0-9\,\&\-\(\)\/\"\.\*\#\s]+(?<!-)$/i',
            'date' => 'required|date',
            'date_in_inv' => 'nullable|date',
            'placement' => 'nullable|numeric'
        ]);

        // Create Update Entry
        Router::findOrFail($id)->update([
            'router_num' => $request->input(['router_num']),
            'part_num' => $request->input(['part_num']),
            'po_num' => $request->input(['po_num']),
            'customer' => $request->input(['customer']),
            'qty' => $request->input(['qty']),
            'stock_qty' => $request->input(['stock_qty']),
            'status' => $request->input(['status']),
            'dept_name' => $request->input(['dept_name']),
            'move_log' => $request->input(['move_log']),
            'date' => $request->input(['date']),
            'date_in_inv' => $request->input(['date_in_inv']),
            'placement' => $request->input(['placement'])
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Router  $id
    * @return \Illuminate\Http\Response
    */
    public function deleteRouter($id)
    {
        $this->authorize('delete', $id);
        return Router::destroy($id);
    }

    /**
    * Get routers report data between two dates
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function betweenDates($start, $end)
    {
        $routers = DB::table('routers')
                            ->select(
                                'id',
                                'router_num', 
                                'qty', 
                                'part_num', 
                                'po_num', 
                                'customer', 
                                'status', 
                                'dept_name', 
                                'date', 
                                'move_log',
                                'placement'
                            )
                            ->whereBetween('date', [$start, $end])
                            ->get();
        return $routers;
    }

    /**
    * Seach for an router by it's router number
    *
    * @param Request $request
    * @return \Illuminate\Http\Response
    */
    public function byRouterNum($term)
    {
        $routers = DB::table('routers')
                            ->select(
                                'id',
                                'router_num', 
                                'qty', 
                                'part_num', 
                                'po_num', 
                                'customer', 
                                'status', 
                                'dept_name', 
                                'date', 
                                'move_log'
                            )
                            ->where('router_num', $term)
                            ->get();
        return $routers;
    }

    /**
     * import an Routers Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      DB::table('routers')->truncate();
      if($request->file('imported-routers')){
                $path = $request->file('imported-routers')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'id' => $row['id'],
                    'router_num' => $row['router_num'],
                    'part_num' => $row['part_num'],
                    'po_num' => $row['po_num'],
                    'customer' => $row['customer'],
                    'qty' => $row['qty'],
                    'stock_qty' => $row['stock_qty'],
                    'status' => $row['status'],
                    'dept_name' => $row['dept_name'],
                    'move_log' => $row['move_log'],
                    'date' => $row['date'],
                    'date_in_inv' => $row['date_in_inv'],
                    'placement' => $row['placement']
                ];
              }
          }
          if(!empty($dataArray)){
             Router::insert($dataArray);
             return redirect('settings')->with('router-import-status', 'Import was successful!');
           }
         }
       }
    }

    /**
     * Export routers as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
      $items = Router::all();
      Excel::create('dataentry-routers', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export routers as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV()
    {
      $items = Router::all();
      Excel::create('dataentry-routers', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }
}
