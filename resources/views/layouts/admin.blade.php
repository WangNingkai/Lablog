<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {!! bootstrap_css() !!}
    {!! fontawesome_css() !!}
    {!! animate_css() !!}
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    {!! sweetalert2_css() !!}
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
{!! jquery_js() !!}
{!! bootstrap_js() !!}
<script src="{{asset('tpl/js/content.min.js')}}"></script>
{!! sweetalert2_js() !!}
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
