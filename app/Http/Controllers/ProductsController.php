<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
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
    public function getProducts() 
    {
        return Product::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',
            'description' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',
            'material' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\.\,\s]+(?<!-)$/i|max:70',
            'rev' => 'nullable|max:3',
            'rev_date' => 'nullable|date'
        ]);
        return Product::create([
            'name' => $request->input(['name']),
            'description' => $request->input(['description']),
            'material' => $request->input(['material']),
            'rev' => $request->input(['rev']),
            'rev_date' => $request->input(['rev_date'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',
            'description' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\s]+(?<!-)$/i|max:25',
            'material' => 'nullable|regex:/^(?!-)(?!.*--)[A-Za-z0-9\-\.\,\s]+(?<!-)$/i|max:70',
            'rev' => 'nullable|max:3',
            'rev_date' => 'nullable|date'
        ]);
        
        Product::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'description' => $request->input(['description']),
            'material' => $request->input(['material']),
            'rev' => $request->input(['rev']),
            'rev_date' => $request->input(['rev_date'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id)
    {
        $this->authorize('delete', $id);
        return Product::destroy($id);
    }
}
