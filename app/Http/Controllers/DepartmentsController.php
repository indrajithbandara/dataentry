<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
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
    public function getDepartments() 
    {
        return Department::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'dept_name' => 'required|alpha|max:50',
            'dept_bg_color' => 'nullable|alphanum|max:6',
            'dept_txt_color' => 'nullable|alphanum|max:6',
            'key' => 'required|numeric'
        ]);
        return Department::create([
            'dept_name' => $request->input(['dept_name']),
            'dept_bg_color' => $request->input(['dept_bt_color']),
            'dept_txt_color' => $request->input(['dept_txt_color']),
            'key' => $request->input(['key'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDepartment(Request $request, $id)
    {
        $this->validate($request, [
            'dept_name' => 'required|alpha|max:50',
            'dept_bg_color' => 'nullable|alphanum|max:6',
            'dept_txt_color' => 'nullable|alphanum|max:6',
            'key' => 'required|numeric'
        ]);
        
        Department::findOrFail($id)->update([
            'dept_name' => $request->input(['dept_name']),
            'dept_bg_color' => $request->input(['dept_bt_color']),
            'dept_txt_color' => $request->input(['dept_txt_color']),
            'key' => $request->input(['key'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deparment  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDeparment($id)
    {
        $this->authorize('delete', $id);
        return Department::destroy($id);
    }

    /**
     * import a departments Excel file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
      if($request->file('imported-deparments')){
                $path = $request->file('imported-departments')->getRealPath();
                $data = Excel::load($path, function($reader){})->get();
          if(!empty($data) && $data->count()){
            foreach ($data->toArray() as $row){
              if(!empty($row)){
                $dataArray[] =
                [
                    'id' => $row['id'],
                    'dept_name' => $row['dept_name'],
                    'dept_bg_color' => $row['dept_bg_color'],
                    'dept_txt_color' => $row['dept_txt_color'],
                    'key' => $row['key']
                ];
              }
          }
          if(!empty($dataArray)){
             Department::insert($dataArray);
             return redirect('settings')->with('department-import-status', 'Import was successful!');
           }
         }
       }
    }

    /**
     * Export departments as an excel file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(){
      $items = Department::all();
      Excel::create('dataentry-departments', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('xls');
    }

    /**
     * Export department as an CSV file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCSV(){
      $items = Department::all();
      Excel::create('dataentry-departments', function($excel) use($items) {
          $excel->sheet('ExportFile', function($sheet) use($items) {
              $sheet->fromArray($items);
          });
      })->export('csv');
    }
}
