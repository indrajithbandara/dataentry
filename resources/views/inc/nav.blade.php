<?php use App\User; ?>
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
                <a class="navbar-brand" href="{{ url('/home') }}">Data Entry</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="padding">
                            <a href="{{ url('/settings') }}"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li class="padding">
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
                        <a href="{{ url('home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    @if( User::isSuperAdmin() || User::isAdmin() )
                        <li><a href="{{ url('invoices') }} "><i class="fa fa-fw fa-money"></i> Invoices</a></li>
                    @endif
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#assets"><i class="fa fa-fw fa-database"></i> Assets <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="assets" class="collapse">

                            @if( User::isSuperAdmin() )
                                <li><a href="{{ url('users') }}"><i class="fa fa-fw fa-user"></i> Users</a></li>
                            @endif

                            @if( User::isSuperAdmin() || User::isAdmin() || User::isManager() )
                                <li><a href="{{ url('products') }}"><i class="fa fa-fw fa-plane"></i> Products</a></li>
                            @endif

                            @if( User::isSuperAdmin() || User::isAdmin() )
                                <li><a href="{{ url('customers') }}"><i class="fa fa-fw fa-users"></i> Customers</a></li>
                            @endif

                        </ul>
                    </li>
{{--                     <li>
                        <a href="{{ url('purchaseorders') }}"><i class="fa fa-fw fa-credit-card"></i> Purchase Orders</a>
                    </li>
                    <li>
                        <a href="{{ url('routers') }}"><i class="fa fa-fw fa-arrows"></i> Routers</a>
                    </li> --}}
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">