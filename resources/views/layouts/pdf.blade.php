<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Levi Gonzales">
    <title>PDF Printout</title>
    <style type="text/css">
    /* alignment */
    .float-left { float: left; }
    .float-right { float: right; }
    .clear-fix { clear: both; }
    .clear-left { clear: left; }
    .clear-right { clear: right; }
    /* spacing */
    .padding-5 { padding: 5px; }
    .padding-50 { padding: 50px; }
    .space { height: 10px }
    .half-width { width: 50%; }
    .full-width { width: 100%; }
    /*.under-half { width: 40%; }*/
    .qtr-width { width: 33.5%; }
    .set-height { height: 100px; }
    /* decoration */
    .border { border: 1px solid #000; }
    /* text & font */
    .font { font-family: Helvetica, Georgia, serif }
    .text-center { text-align: center; }
    .sm-text { font-size: 12px; }
    .md-text { font-size: 14px; }
    .lg-text { font-size: 16px; }
    </style>

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
        @yield('content')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
