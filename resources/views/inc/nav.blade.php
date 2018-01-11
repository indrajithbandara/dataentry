        <!-- Navigation -->
        <nav class="navbar navbar-inverse main-color navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/dashboard') }}">Dataentry</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @if( Auth::user()->permission == 1 )
                            <li class="padding" style="margin-right: 10px">
                                <a href="{{ url('/settings') }}"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                        @endif
                        <li class="padding" style="margin-right: 10px;">
                            <a href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i> 
                                Log Out
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav main-color">
                    <li>
                        <a href="{{ url('/dashboard') }}"><i class="fa fa-fw fa-dashboard" aria-hidden="true"></i> Dashboard</a>
                    </li>
                    @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 )
                        <li><a href="{{ url('invoices') }} "><i class="fa fa-fw fa-money" aria-hidden="true"></i> Invoices</a></li>
                    @endif
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#assets"><i class="fa fa-fw fa-database" aria-hidden="true"></i> Assets <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="assets" class="collapse">

                            @if( Auth::user()->permission == 1 )
                                <li><a href="{{ url('users') }}"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Users</a></li>
                            @endif

                            @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3 )
                                <li><a href="{{ url('products') }}"><i class="fa fa-fw fa-plane" aria-hidden="true"></i> Products</a></li>
                            @endif

                            @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 )
                                <li><a href="{{ url('customers') }}"><i class="fa fa-fw fa-users" aria-hidden="true"></i> Customers</a></li>
                            @endif

                        </ul>
                    </li>
                    @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3 )
                        <li><a href="{{ url('routers') }} "><i class="fa fa-fw fa-arrows" aria-hidden="true"></i> Routers</a></li>
                    @endif
                    @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3 )
                        <li><a href="{{ url('inventory') }} "><i class="fa fa-fw fa-ticket" aria-hidden="true"></i> Inventory</a></li>
                    @endif
                    @if( Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3 )
                        <li><a href="{{ url('purchaseorders') }} "><i class="fa fa-fw fa-tasks" aria-hidden="true"></i> Purchase Orders</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">