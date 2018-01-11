<?php
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    // ==================== Products Api ==================== //
    Route::get('products', 'ProductsController@getProducts'); // Get All Products
    Route::get('products/{id}', 'ProductsController@getOne'); // Get One Product For Editing
    Route::post('products/store', 'ProductsController@addProduct'); // Add A Single Product
    Route::patch('products/{id}', 'ProductsController@updateProduct'); // Update A Single Product
    Route::delete('products/{id}', 'ProductsController@deleteProduct'); // Delete A Single Product
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
    Route::get('customers/count', 'CustomersController@count'); // Get count of customers
    Route::get('customers/{id}', 'CustomersController@getCustomer'); // Get One Customer for Editing
    Route::post('customers/store', 'CustomersController@addCustomer'); // Add A Single Custer
    Route::patch('customers/{id}', 'CustomersController@updateCustomer'); // Update a Single Customer
    Route::delete('customers/{id}', 'CustomersController@deleteCustomer'); // Delete a Single Customer
    //====================== End of Customers Api ================ //

    //====================== Invoices Api ====================== //
    Route::get('invoices', 'InvoicesController@getInvoices'); // Get all Invoices
    Route::get('invoices/count', 'InvoicesController@count'); // Get count of invoices
    Route::get('invoices/{id}', 'InvoicesController@getOne'); // Get One Invoice for Editing
    Route::get('invoices/report/{start}/{end}', 'InvoicesController@betweenDates'); // Get the invoices between two given dates
    Route::get('invoices/search/{term}', 'InvoicesController@byInvoiceNum'); // searches for an invoice by inv_num
    Route::post('invoices/store', 'InvoicesController@addInvoice'); // Add A Single Invoice
    Route::patch('invoices/{id}', 'InvoicesController@updateInvoice'); // Update a Single Invoice
    Route::delete('invoices/{id}', 'InvoicesController@deleteInvoice'); // Delete a Single Invoice
    //====================== End of Invoices Api ====================== //

    //====================== Company Api ====================== //
    Route::get('company', 'CompanyController@getName'); //Get company info for viewing
    Route::get('company/{id}', 'CompanyController@getOne'); // Get company for editing
    Route::get('invoice/prefix', 'CompanyController@getInvPrefix'); // Get the invoice prefix number
    Route::post('company/store', 'CompanyController@addCompany'); // Add the company info
    Route::patch('company/{id}', 'CompanyController@updateCompany'); // Update the company info
    // No Delete Functionality. This api is for the company info using the application.
    //====================== End of Company Api ====================== //

    //====================== Routers Api ====================== //
    Route::get('routers', 'RoutersController@getRouters'); // Get all Routers
    Route::get('routers/count', 'RoutersController@count'); // Get count of routers
    Route::get('routers/{id}', 'RoutersController@getOne'); // Get One Router for Editting
    Route::get('routers/report/{start}/{end}', 'RoutersController@betweenDates'); // Get the routers between two given dates
    Route::get('routers/search/{term}', 'RoutersController@byRouterNum'); // Searches for a router by router_num
    Route::post('routers/store', 'RoutersController@addRouter'); // Add a single router
    Route::patch('routers/{id}', 'RoutersController@updateRouter'); // Update a single router
    Route::delete('routers/{id}', 'RoutersController@deleteRouter'); // Delete a Single Router
    //====================== End of Routers Api ====================== //

    //====================== Departments Api ====================== //
    Route::get('departments', 'DepartmentsController@getDepartments'); // Get all Departments
    Route::get('departments/{id}', 'DepartmentsController@getOne'); // Get One Department for Editting
    Route::post('departments/store', 'DepartmentsController@addDepartment'); // Add a single department
    Route::patch('departments/{id}', 'DepartmentsController@updateDeparment'); // Update a single department
    Route::delete('departments/{id}', 'DepartmentsController@deleteDepartment'); // Delete a Single department
    //====================== End of Departments Api ====================== //

    //====================== Inventory Api ====================== //
    Route::get('inventory', 'InventoryController@getInventory'); // Get all of inventory ship tickets
    Route::get('inventory/{id}', 'InventoryController@getOne'); // Get One Inventory ship ticket for Editting
    Route::get('inventory/report/{start}/{end}', 'InventoryController@betweenDates'); // Get the inventory ship tickets between two given dates
    Route::get('inventory/search/{term}', 'InventoryController@byIstNum'); // Searches for a router by ist_num
    Route::post('inventory/store', 'InventoryController@addInventory'); // Add a single Inventory Ship Ticket
    Route::patch('inventory/{id}', 'InventoryController@updateInventory'); // Update a single Inventory Ship Ticket
    Route::delete('inventory/{id}', 'InventoryController@deleteInventory'); // Delete a Single Inventory Ship Ticket
    //====================== End of Inventory Api ====================== //

    //====================== Purchase Orders Api ====================== //
    Route::get('purchaseorders', 'PurchaseordersController@getPurchaseorders'); // Get all purchase orders
    Route::get('purchaseorders/count', 'PurchaseordersController@count'); // Get count of purchase orders
    Route::get('purchaseorders/{id}', 'PurchaseordersController@getOne'); // Get One Invoice for Editing
    Route::get('purchaseorders/report/{start}/{end}', 'PurchaseordersController@betweenDates'); // Get the invoices between two given dates
    Route::get('purchaseorders/search/{term}', 'PurchaseordersController@byPoNum'); // searches for an invoice by inv_num
    Route::post('purchaseorders/store', 'PurchaseordersController@addPurchaseorder'); // Add A Single Invoice
    Route::patch('purchaseorders/{id}', 'PurchaseordersController@updatePurchaseorder'); // Update a Single Invoice
    Route::delete('purchaseorders/{id}', 'PurchaseordersController@deletePurchaseorder'); // Delete a Single Invoice
    //====================== End of Purchase Orders Api ====================== //
});


