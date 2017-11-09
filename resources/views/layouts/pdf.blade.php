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
    .inline { display: inline-block; }
    /* spacing */
    .padding-5 { padding: 5px; }
    .padding-15 { padding: 15px; }
    .padding-50 { padding: 50px; }
    .padding-50-lr { padding: 10px 50px; }
    .padding-20-sides { padding-left: 20px; padding-right: 20px; }
    .padding-25-sides { padding-left: 25px; padding-right: 25px; }
    .padding-46-sides { padding-left: 46px; padding-right: 46px; }
    .less-margin-tb { margin: 5px 0; }
    .margin-bottom-20 { margin-bottom: 20px; }
    .margin-little { margin: 5px; }
    .margin-none { margin: 0; }
    .space { height: 10px }
    .more-space { height: 90px; }
    .height-150 { max-height: 150px; }
    .small-width { width: 10%; }
    .qtr-width { width: 25%; }
    .less-qtr-width { width: 24%; }
    .half-width { width: 50%; }
    .full-width { width: 100%; }
    .under-half { width: 40%; }
    .qtr-width { width: 29%; }
    .set-height { height: 50px; }
    /* decoration */
    .border { border: 1px solid #000; }
    .light-border { border: 1px solid #aaa; }
    .underline { text-decoration: underline; }
    /* text & font */
    .font { font-family: Helvetica, Georgia, serif }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
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
