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
    {!! bootstrap_css() !!}
    {!! fontawesome_css() !!}
    {!! animate_css() !!}
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
{!! jquery_js() !!}
{!! bootstrap_js() !!}
{!! pace_js() !!}
</body>
</html>
