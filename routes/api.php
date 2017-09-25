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

    //====================== Customers Api ====================== //
    Route::get('customers', 'CustomersController@getCustomers'); // Get all Customers
    Route::get('customers/{id}', 'CustomersController@getCustomer'); // Get One Customer for Editing
    Route::post('customers/store', 'CustomersController@addCustomer'); // Add A Single Custer
    Route::patch('customers/{id}', 'CustomersController@updateCustomer'); // Update a Single Customer
    Route::delete('customers/{id}', 'CustomersController@deleteCustomer'); // Delete a Single Customer
    //====================== End of Customers Api ================ //

    //====================== Invoices Api ====================== //
    Route::get('invoices', 'InvoicesController@getInvoices'); // Get all Invoices
    Route::get('invoices/{id}', 'InvoicesController@getInvoice'); // Get One Invoice for Editing
    Route::post('invoices/store', 'InvoicesController@addInvoice'); // Add A Single Invoice
    Route::patch('invoices/{id}', 'InvoicesController@updateInvoice'); // Update a Single Invoice
    Route::delete('invoices/{id}', 'InvoicesController@deleteInvoice'); // Delete a Single Invoice
    //====================== End of Invoices Api ====================== //
});


