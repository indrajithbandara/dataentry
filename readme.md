<h1 align="center">Data Entry System</h1>
<h3 align="center">A data entry system for companies with product driven warehouses.</h3>
This project is currently in session. It's main purpose is for managing products, invoices and shipping information as well as 
handel the tracking of purchase orders, travelers and inventory.

### The System currently includes
1. a simple dashboard.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/dashboard.png">
2. company information area and assets reset abilities.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/settings_2.png">
3. the ability to import and export data in either CSV or Excel format.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/settings_1.png">
4. customers interface for recording and viewing customer information.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/customers.png">
5. products interface for recording and viewing product information.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/products.png">
6. an invoices interface for creating and viewing invoices.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/invoice_form.png">
7. the ability to print invoice reports, invoices and shippers along with searching for specific invoices.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/invoice_table.png">
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/reports.png">
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/search.png">
8. the ability to create multiple users and give them certain permissions over the system.
<img src="https://github.com/lvstross/dataentry/blob/master/public/img/users.png">

#### Other features include:
1. Error and Success Messages.
2. Mobile Responsiveness with Bootstrap.
3. Warning messages along with input validation.
4. pdf printables for invoices, shippers and reports.
5. information cards for every input area.

### Features To Come
1. Traveler Interface
2. Product Department Chart
3. Inventory Interface
4. Purchase Orders Interface

### General SetUp
This applications was built on Laravel 5.4 and developed in a LEMP environment.
1. Rename the .env.example file to .env.
2. Fill in the following in the .env file.
```
   DB_DATABASE=dbname
   DB_USERNAME=root
   DB_PASSWORD=
```
3. Create a database with the name you put for the DB_DATABASE config
4. Run these commands to install all the needed packages.
```bash
~ composer install
~ npm install
~ npm run dev
```
5. Migrate the database files.
```bash
~ php artisan migrate
```
6. Run these commands to generate the nessesary keys
```bash
~ php artisan key:generate
~ php artisan passport:keys
```
7. Serve up the application.
```bash
~ php artisan serve
```
8. If you are making changes to any of the javascript files, run
```bash
~ npm run watch
```

Once you have successfully opened the home page on the local host server, go to '/register' and make an account.
This initial registration is a one time registrations as all other users are supposed to created in the backend of the 
application in '/users'. All future visits to '/register' will be redirected to the '/login' page.