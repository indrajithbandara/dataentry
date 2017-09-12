@extends('layouts.main')

@section('content')
    {{-- Users Template --}}
    @if(Request::is('users'))
        <div id="users-app">
            <users></users>
        </div>
    @endif

    {{-- Customers Template --}}
    @if(Request::is('customers'))
        <div id="customers-app">
            <customers></customers>
        </div>
    @endif

    {{-- Products Template --}}
    @if(Request::is('products'))
        <div id="products-app">
            <products></products>
        </div>
    @endif

    {{-- Invoices Template --}}
    @if(Request::is('invoices'))
        <div id="invoice-app">
            <invoices></invoices>
        </div>
    @endif

    {{-- Purchase Orders Template --}}
{{--     @if(Request::is('purchaseorders'))
        <div id="purchaseorders-app">
            <purchaseorders></purchaseorders>
        </div>
    @endif --}}

    {{-- Routers Template --}}
{{--     @if(Request::is('routers'))
        <div id="routers-app">
            <routers></routers>
        </div>
    @endif --}}

    {{-- Inventory Template --}}
{{--     @if(Request::is('inventory'))
        <div id="inventory-app">
            <inventory></inventory>
        </div>
    @endif --}}
@endsection