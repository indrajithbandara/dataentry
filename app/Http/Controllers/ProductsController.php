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

    // Get all products
    public function getProducts() 
    {
        return Product::all();
    }

    // Get One Product
    public function getOne($id)
    {
        return Product::findOrFail($id);
    }

    // Add a product
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

    // Update Product
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

    // Delete Product
    public function deleteProduct($id)
    {
        $this->authorize('delete', $id);
        return Product::destroy($id);
    }
}
