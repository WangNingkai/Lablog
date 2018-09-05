<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>
    <link href="https://lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://lib.baomitu.com/ionicons/3.0.0/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.min.css')}}">
    <link href="https://lib.baomitu.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">
    <link href="https://lib.baomitu.com/limonte-sweetalert2/7.21.1/sweetalert2.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- 警告：Respond.js 不支持 file:// 方式查看（即本地方式查看）-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="http://fonts.lug.ustc.edu.cn/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition @yield('name')-page">
<div class="@yield('name')-box">
    <div class="@yield('name')-logo">
        <a href="{{ route('home') }}"><b>LABLOG</b>博客</a>
    </div>
    @yield('content')
</div>

<script src="https://lib.baomitu.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://lib.baomitu.com/iCheck/1.0.2/icheck.min.js"></script>
<script src="https://lib.baomitu.com/limonte-sweetalert2/7.21.1/sweetalert2.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
@include('vendor.message')
</body>
</html>
