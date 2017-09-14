<?php

// Route for loading the front guest page
Route::get('/', function () { return view('welcome'); });

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

// Route Group passed through web and auth middleware for the main page. 
Route::group(['middleware' => ['web', 'auth']], function(){

    // Users web route
    Route::get('/users', 'PagesController@users');
    // End Users Web route

    // Customers Web Route
    Route::get('/customers', function(){
        if ( Gate::allows('admin', Auth::user()) || Gate::allows('admin_two', Auth::user())){
            return view('page');
        } else {  
            return abort(401); 
        }
    });
    // End Customers Route

    // Products Web Route
    Route::get('/products', function(){
        if ( Gate::allows('admin', Auth::user()) || Gate::allows('admin_two', Auth::user()) || Gate::allows('manage_three', Auth::user()) ){
            return view('page');
        } else {  
            return abort(401); 
        }
    });
    // End Products Route

    // Invoices Web Route
    Route::get('/invoices', function(){ 
        if ( Gate::allows('admin', Auth::user()) || Gate::allows('admin_two', Auth::user())){
            return view('page');
        } else {  
            return abort(401); 
        }
    });
    // End Invoices Route
    

    // Routes to be determined
    // Route::get('/purchaseorders', function(){ return Gate::allows('admin', Auth::user()) ? view('page') : abort(401); });
    // Route::get('/routers', function(){ return Gate::allows('admin', Auth::user()) ? view('page') : abort(401); });
    // Route::get('/inventory', function(){ return Gate::allows('admin', Auth::user()) ? view('page') : abort(401); });

});