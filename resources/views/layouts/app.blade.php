<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- <link href="{{asset('tpl/css/bootstrap.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="{{asset('tpl/css/font-awesome.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link href="{{asset('tpl/css/animate.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('tpl/custome/css/home.custome.css')}}" rel="stylesheet">
</head>
<body class="gray-bg top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <!--导航栏  -->
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a href="{{route('home')}}" class="navbar-brand">{{ config('app.name', 'NK') }}</a>
                </div>
            </nav>
        </div>
        <!--导航栏  -->
        <div class="wrapper wrapper-content main-content">
            @yield('content')
        </div>

    </div>
</div>
<!-- Scripts -->
<!-- <script src="{{asset('tpl/js/jquery.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="{{asset('tpl/js/bootstrap.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- <script src="{{asset('tpl/plugins/pace/pace.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
</body>
</html>
