<?php

// Route for loading the front guest page
Route::get('/', function () { return view('welcome'); });

// Authentications shortcut for default routes.
Auth::routes();

/** 
*   Single Page App Routes
*   'Auth' Middleware has been added on the PagesController.php
*   page via the controller constructor.
*/

// Route Group passed through web and auth middleware for the main page. 
Route::group(['middleware' => ['web', 'auth']], function(){
    Route::get('/dashboard', 'HomeController@dashboard')->name('home');
    Route::get('/settings', 'HomeController@settings')->name('settings');
    Route::get('/invoices', 'PagesController@invoices');
    Route::get('/users', 'PagesController@users');
    Route::get('/customers', 'PagesController@customers');
    Route::get('/products', 'PagesController@products');
    // PDF Generation Routes
    Route::get('/pdf/invoice/{id}', 'PDFController@invoice');
    Route::get('/pdf/shipper/{id}', 'PDFController@shipper');
    Route::get('/pdf/report/invoice/{start}/{end}', 'PDFController@invoiceReport');
    // Importing and Exporting Customers Files
    Route::post('customers/import', 'CustomersController@import');
    Route::get('customers/export/excel', 'CustomersController@exportExcel');
    Route::get('customers/export/csv', 'CustomersController@exportCSV');
    Route::get('customers/export/drop', 'CustomersController@dropAndExport');
    // Importing and Exporting Products Files
    Route::post('products/import', 'ProductsController@import');
    Route::get('products/export/excel', 'ProductsController@exportExcel');
    Route::get('products/export/csv', 'ProductsController@exportCSV');
    Route::get('products/export/drop', 'ProductsController@dropAndExport');
    // Importing and Exporting Invoices Files
    Route::post('invoices/import', 'InvoicesController@import');
    Route::get('invoices/export/excel', 'InvoicesController@exportExcel');
    Route::get('invoices/export/csv', 'InvoicesController@exportCSV');
    Route::get('invoices/export/drop', 'InvoicesController@dropAndExport');
});