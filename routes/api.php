<?php
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    // ==================== Products Api ==================== //
    Route::get('products', 'ProductsController@getProducts'); // Get All Products
    Route::get('products/{product}', 'ProductsController@getOne'); // Get One Product For Editing
    Route::post('products/store', 'ProductsController@addProduct'); // Add A Single Product
    Route::patch('products/{product}', 'ProductsController@updateProduct'); // Update A Single Product
    Route::delete('products/{product}', 'ProductsController@deleteProduct'); // Delete A Single Product
    // ==================== End of Products Api ==================== //
});


