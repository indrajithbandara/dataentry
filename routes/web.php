<?php

// Route for loading the front guest page
Route::get('/', function () {return view('welcome');});

// Route for loading the dashboard page
Route::get('/home', 'HomeController@index')->name('home');

// Default auth routes added when php artisan make:auth was ran. 
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
Route::get('/users', 'PagesController@vuePage');
Route::get('/customers', 'PagesController@vuePage');
Route::get('/products', 'PagesController@vuePage');
Route::get('/purchaseorders', 'PagesController@vuePage');
Route::get('/invoices', function(){
    if(Gate::allows('admin-only', Auth::user())){
        return view('page');
    }else{
        return 'You are not authorized to view this page.';
    }
});
Route::get('/routers', 'PagesController@vuePage');
Route::get('/inventory', 'PagesController@vuePage');