                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">
                            @if(Request::is('purchaseorders'))
                                Purchase Orders
                            @elseif(Request::is('users'))
                                Users
                            @elseif(Request::is('products'))
                                Products
                            @elseif(Request::is('invoices'))
                                Invoices
                            @elseif(Request::is('routers'))
                                Routers
                            @elseif(Request::is('customers'))
                                Customers
                            @elseif(Request::is('settings'))
                                Settings
                            @else
                                Dashboard
                            @endif
                            <small>
                            @if(Request::is('/add'))
                                Add
                            @endif
                            @if(Request::is('/view'))
                                View
                            @endif
                            </small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

<!-- 
    will need logic to display for the 404 error page headings.
 -->