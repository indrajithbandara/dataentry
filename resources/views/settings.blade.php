@extends('layouts.main')

@section('content')
    <div id="settings-app">
        <settings></settings>
    </div>
    <hr>
    <!-- Import and Export Customer Section -->
    <h3>Import / Export Customers Data</h3>
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
    <h3>Import / Export Products Data</h3>
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
    <h3>Import / Export Invoice Data</h3>
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
@endsection
