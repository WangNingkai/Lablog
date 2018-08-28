<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name }}</title>
    <style type="text/css">
        * {margin: auto;padding: 0;border: 0;}
        html {-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%}
        body {font-family: -apple-system, SF UI Text, Arial, Microsoft YaHei,
        sans-serif;color: #333;}
        img {max-width: 100%;}
        h3 {padding: 10px;}
        .container {text-align: center;}
        .title {padding: 2em 0;background-color: #fff;}
        .content {padding: 2em 1em;color: #fff;}
        .wepay {background-color: #23ac38;}
        .other {background-color: #ff7055;}
    </style>
</head>
<body class="{{ $type }}">
<div class="container">
    <div class="title">{{ $icon_img }}<h1>{{ $name }}</h1></div>
    <div  class="content">
        @if ($type=='other')
            {{ $qr_img }}<h3>请使用支付宝、微信客户端扫码付款</h3>'
        @else
            {{ $qr_img }}<h3>扫描或长按识别二维码，向TA付款</h3>'
        @endif
    </div>
</div>
</body>
</html>
