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
    Route::get('/routers', 'PagesController@routers');
    Route::get('/inventory', 'PagesController@inventory');
    Route::get('/purchaseorders', 'PagesController@purchaseorders');
    // PDF Generation Routes
    Route::get('/pdf/invoice/{id}', 'PDFController@invoice');
    Route::get('/pdf/shipper/{id}', 'PDFController@shipper');
    Route::get('/pdf/report/invoice/{start}/{end}/{reportname?}', 'PDFController@invoiceReport');
    Route::get('/pdf/report/router/{start}/{end}/{reportname?}', 'PDFController@routerReport');
    Route::get('/pdf/report/inventory/{start}/{end}/{reportname?}', 'PDFController@inventoryReport');
    Route::get('/pdf/report/purchaseorder/{start}/{end}/{reportname?}', 'PDFController@purchaseorderReport');
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
    // Importing and Exporting Routers Files
    Route::post('routers/import', 'RoutersController@import');
    Route::get('routers/export/excel', 'RoutersController@exportExcel');
    Route::get('routers/export/csv', 'RoutersController@exportCSV');
    // Importing and Exporting Department Files
    Route::post('departments/import', 'DepartmentsController@import');
    Route::get('departments/export/excel', 'DepartmentsController@exportExcel');
    Route::get('departments/export/csv', 'DepartmentsController@exportCSV');
    // Importing and Exporting Inventory Files
    Route::post('inventory/import', 'InventoryController@import');
    Route::get('inventory/export/excel', 'InventoryController@exportExcel');
    Route::get('inventory/export/csv', 'InventoryController@exportCSV');
    // Importing and Exporting Purchaseorders Files
    Route::post('purchaseorders/import', 'PurchaseordersController@import');
    Route::get('purchaseorders/export/excel', 'PurchaseordersController@exportExcel');
    Route::get('purchaseorders/export/csv', 'PurchaseordersController@exportCSV');
});