<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>关站中</title>
    <link href="{{asset('tpl/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('tpl/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="middle-box text-center animated bounceInDown">
                <h2>{{$config['site_close_word']}}</h2>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('tpl/js/jquery.min.js')}}"></script>
<script src="{{asset('tpl/js/bootstrap.min.js')}}"></script>
</body>

</html>
