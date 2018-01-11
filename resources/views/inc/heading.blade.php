                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">
                            @if(Request::is('purchaseorders'))
                                Purchase Orders
                            @elseif(Request::is('dashboard'))
                                Dashboard
                            @elseif(Request::is('users'))
                                Users
                            @elseif(Request::is('products'))
                                Products
                            @elseif(Request::is('invoices'))
                                Invoices
                            @elseif(Request::is('routers'))
                                {{-- Nothing --}}
                            @elseif(Request::is('customers'))
                                Customers
                            @elseif(Request::is('settings'))
                                Settings
                            @elseif(Request::is('inventory'))
                                Inventory
                            @else
                                {{-- Nothing --}}
                            @endif
                        </h1>
                    </div>
                </div>
                <!-- /.row -->