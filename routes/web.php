<?php

// Route for loading the front guest page
Route::get('/', function () { return view('welcome'); });

// Authentications shortcut for default routes.
Auth::routes();

/** 
*   Single Page App Routes
*   All routes called the vuePage() method in PageController
*   to load resources/views/page.blade.php that is responsable for 
*   checking the uri and loads the correct vue instance.
*
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
    Route::get('/pdf/invoice/{id}', 'PDFController@invoice');
    Route::get('/pdf/shipper/{id}', 'PDFController@shipper');
    Route::get('/pdf/report/invoice/{start}/{end}', 'PDFController@invoiceReport');
});