<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- <link href="{{asset('tpl/css/bootstrap.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="{{asset('tpl/css/font-awesome.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link href="{{asset('tpl/css/animate.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/limonte-sweetalert2/7.19.1/sweetalert2.min.css" rel="stylesheet">
    <script>
        var indexUrl = "{{ route('dashboard') }}";
    </script>
    @yield('css')
</head>

<body class="gray-bg">
<div class="row wrapper border-bottom white-bg page-heading">
    @section('page-heading')
        <div class="col-sm-4">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
        </div>
    @show
</div>
<div class="wrapper wrapper-content animated fadeIn">
    @include('errors.validator')
    <div class="row">
        <div class="col-sm-12">
            @yield('content')
        </div>
    </div>
</div>
<!-- <script src="{{asset('tpl/js/jquery.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="{{asset('tpl/js/bootstrap.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{asset('tpl/js/content.min.js')}}"></script>
<!-- <script src="{{asset('tpl/plugins/sweetalert2/sweetalert2.min.js')}}"></script> -->
<script src="https://cdn.bootcss.com/limonte-sweetalert2/7.19.1/sweetalert2.min.js"></script>
<script left="85%" bottom="10%" text="返回顶部" src="{{asset('tpl/js/returnTop.js')}}"></script>
@if(Session::has('alertMessage'))
    <script>
        $(function () {
            @if(Session::get('alertType')=='success')
            swal("操作成功", "{{Session::get('alertMessage')}}", "success")
            @else
            swal("操作失败", "{{Session::get('alertMessage')}}", "error")
            @endif
        });
    </script>
@endif
@yield('js')
</body>

</html>
