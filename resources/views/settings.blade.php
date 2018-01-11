@extends('layouts.main')

@section('content')
    <h2 class="text-center">Import / Export</h2>
    <div class="well">
        <!-- Import and Export Customer Section -->
        <h3>Customers Data</h3>
        <div class="well">
            @if (session('customer-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('customer-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('customers/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-customers"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('customers/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('customers/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Import and Export Products Section -->
        <h3>Products Data</h3>
        <div class="well">
            @if (session('product-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('product-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('products/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-products"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('products/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('products/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Import and Export Invoice Section -->
        <h3>Invoices Data</h3>
        <div class="well">
            @if (session('invoice-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('invoice-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('invoices/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-invoices"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('invoices/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('invoices/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import and Export Routers Section -->
        <h3>Routers Data</h3>
        <div class="well">
            @if (session('router-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('router-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('routers/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-routers"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('routers/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('routers/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import and Export inventory Section -->
        <h3>Inventory Data</h3>
        <div class="well">
            @if (session('inventory-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('inventory-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('inventory/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-inventory"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('inventory/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('inventory/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import and Export Department Section -->
        <h3>Department Data</h3>
        <div class="well">
            @if (session('department-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('department-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('departments/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-departments"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('departments/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('departments/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import and Export Purchaseorder Section -->
        <h3>Purchase Order Data</h3>
        <div class="well">
            @if (session('purchaseorders-import-status'))
                <div class="full-width alert alert-success alert-dismissable text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('purchaseorders-import-status') }}
                </div>
            @endif
            <div class="row">
                <form action="{{url('purchaseorders/import')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-3">
                        <input type="file" name="imported-purchaseorders"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm full-width" type="submit"><i class="fa fa-download" aria-hidden="true"></i> Import</button>
                    </div>
                </form>
                <div class="col-md-3">
                    <form action="{{url('purchaseorders/export/excel')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As Excel File</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form action="{{url('purchaseorders/export/csv')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-sm full-width" type="submit"><i class="fa fa-upload" aria-hidden="true"></i> Export As CSV File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="settings-app">
        <settings></settings>
    </div>
@endsection
