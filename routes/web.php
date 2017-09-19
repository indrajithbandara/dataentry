<?php

use App\User;

// Route for loading the front guest page
Route::get('/', function () { return view('welcome'); });

// Route for loading the dashboard page
Route::get('/home', 'HomeController@index')->name('home');
// Route for loading the settings page
Route::get('/settings', 'HomeController@index')->name('settings');



// Authentications shortcut for default routes.
// Auth::routes();

// Authentication Routes for overiding
Route::get('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);



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

    Route::get('/invoices', 'PagesController@invoices');
    Route::get('/users', 'PagesController@users');
    Route::get('/customers', 'PagesController@customers');
    Route::get('/products', 'PagesController@products');
    
    // Routes to be determined
    // Route::get('/purchaseorders', 'PagesController@vuePage');
    // Route::get('/routers', 'PagesController@vuePage');
    // Route::get('/inventory', 'PagesController@vuePage');

});