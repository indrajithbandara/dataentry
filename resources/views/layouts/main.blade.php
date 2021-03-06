<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Levi Gonzales">
    <title>Dataentry System</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}">
    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="main-color">
    <!-- #wrapper -->
    <div id="wrapper">
        <!-- #page-wrapper -->
        <div id="page-wrapper">
            <!-- .container-fluid -->
            <div class="container-fluid">
                @include('inc.nav')
                @include('inc.heading')

                @yield('content')
            </div>
            <!-- /.container-fluid end -->
        </div>
        <!-- /#page-wrapper end -->
   </div>
    <!-- /#wrapper end -->
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>