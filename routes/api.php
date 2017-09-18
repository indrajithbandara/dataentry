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

    // ==================== Users Api ======================== //
    Route::get('users', 'UsersController@getUsers'); // Get All Users
    Route::get('users/{id}', 'UsersController@getUser'); // Get One User for Editing
    Route::post('users/store', 'UsersController@addUser'); // Add A Single User
    Route::patch('users/{id}', 'UsersController@updateUser'); // Update A Single User
    Route::delete('users/{id}', 'UsersController@deleteUser'); // Delete A Single User
    // ==================== End of Users Api ======================== //    
});


