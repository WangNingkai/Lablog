<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>关站中</title>
    {!! bootstrap_css() !!}
    {!! animate_css() !!}
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
{!! jquery_js() !!}
{!! bootstrap_js() !!}
</body>

</html>
