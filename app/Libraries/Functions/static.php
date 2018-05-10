<?php

if (!function_exists('bootstrap_css')) {

    function bootstrap_css()
    {
        return '<!--bootstrap_css-->
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">';
    }
}
if (!function_exists('bootstrap_js')) {

    function bootstrap_js()
    {
        return '<!--bootstrap_js-->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        ';
    }
}
if (!function_exists('jquery_js')) {

    function jquery_js()
    {
        return '<!--jquery_js-->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
        ';
    }
}
if (!function_exists('pace_js')) {

    function pace_js()
    {
        return '<!--pace_js-->
<script src="https://cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
        ';
    }
}
if (!function_exists('sweetalert2_css')) {

    function sweetalert2_css()
    {
        return '<!--sweetalert2_css-->
<link href="https://cdn.bootcss.com/limonte-sweetalert2/7.19.1/sweetalert2.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('sweetalert2_js')) {

    function sweetalert2_js()
    {
        return '<!--sweetalert2_js-->
<script src="https://cdn.bootcss.com/limonte-sweetalert2/7.19.1/sweetalert2.min.js"></script>
        ';
    }
}
if (!function_exists('animate_css')) {

    function animate_css()
    {
        return '<!--animate_css-->
<link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('fontawesome_css')) {

    function fontawesome_css()
    {
        return '<!--fontawesome_css-->
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('ickeck_css')) {

    function ickeck_css()
    {
        return '<!--ickeck_css-->
<link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('icheck_js')) {

    function icheck_js()
    {
        return '<!--icheck_js-->
<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
        ';
    }
}
if (!function_exists('validate_js')) {

    function validate_js()
    {
        return '<!--validate_js-->
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/localization/messages_zh.min.js"></script>
        ';
    }
}
if (!function_exists('datatables_css')) {

    function datatables_css()
    {
        return '<!--datatables_css-->
<link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('datatables_js')) {

    function datatables_js()
    {
        return '<!--datatables_js-->
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
        ';
    }
}
if (!function_exists('scrooll_js')) {

    function scrooll_js()
    {
        return '<!--scrooll_js-->
<script src="https://cdn.bootcss.com/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
        ';
    }
}
if (!function_exists('highlight_css')) {

    function highlight_css()
    {
        return '<!--highlight_css-->
<link href="https://cdn.bootcss.com/highlight.js/9.12.0/styles/atom-one-dark.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('highlight_js')) {

    function highlight_js()
    {
        return '<!--highlight_js-->
<script src="https://cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
        ';
    }
}
if (!function_exists('social_css')) {

    function social_css()
    {
        return '<!--social-share-->
<link href="https://cdn.bootcss.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
        ';
    }
}
if (!function_exists('social_js')) {

    function social_js()
    {
        return '<!--social-share-->
<script src="https://cdn.bootcss.com/social-share.js/1.0.16/js/jquery.share.min.js"></script>
        ';
    }
}
if (!function_exists('baidu_push_js')) {

    function baidu_push_js()
    {
        return '<!--baidu_push_js-->
<script>
(function(){
    var bp = document.createElement(\'script\');
    var curProtocol = window.location.protocol.split(\':\')[0];
    if (curProtocol === \'https\') {
        bp.src = \'https://zz.bdstatic.com/linksubmit/push.js\';
    }
    else {
        bp.src = \'http://push.zhanzhang.baidu.com/push.js\';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
        ';
    }
}

if (!function_exists('busuanzi_js')) {

    function busuanzi_js()
    {
        return '<!--busuanzi_js-->
<script async src="//dn-lbstatics.qbox.me/busuanzi/2.3/busuanzi.pure.mini.js"></script>
        ';
    }
}
