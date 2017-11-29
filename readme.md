<h1 align="center">Data Entry System</h1>
<h3 align="center">A data entry system for companies with product driven warehouses.</h3>
The project is currently in session, It's main purpose is manage product, invoice and shipping information.

### Current Features
1. Dashboard
2. Users Interface
3. Customers Interface
4. Products Interface
1. Invoiceing Interface
2. Company / Settings Interface

### Features To Come
1. Traveler Interface
2. Product Department Chart
3. Inventory Interface
4. Purchase Orders Interface

### General SetUp
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

Once you have successfully opened the home page on the local host server, go to /register and make an account. 
This should log you into the application. 