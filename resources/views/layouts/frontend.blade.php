<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.min.css')}}">
    <link href="{{asset('css/frontend.custome.css')}}" rel="stylesheet">
{!! sweetalert2_css() !!}
{!! pace_css('black') !!}
@yield('css')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- 警告：Respond.js 不支持 file:// 方式查看（即本地方式查看）-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.lug.ustc.edu.cn/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-black layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="{{ route('home')}}" class="navbar-brand">
                        <b>{{ $config['site_name'] }}</b></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse " id="navbar-collapse">
                    <form class="navbar-form navbar-left" role="search" action="{{ route('search') }}" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="搜索">
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        @foreach($nav_list as $nav_v)
                            @if($nav_v->type === \App\Models\Nav::TYPE_MENU)
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{ $nav_v->name }}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach($category_list as $category_v)
                                            <li>
                                                <a href="{{ route('category',$category_v->id) }}">{{ $category_v->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @elseif($nav_v->type === \App\Models\Nav::TYPE_ARCHIVE)
                                <li>
                                    <a href="{{ route('archive') }}">{{ $nav_v->name }}</a>
                                </li>
                            @elseif($nav_v->type === \App\Models\Nav::TYPE_EMPTY)
                                @if(!blank($nav_v->children))
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $nav_v->name }}
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach( $nav_v->children as $nav_son )
                                                <li>
                                                    <a href="{{ $nav_son->url }}">{{ $nav_son->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $nav_v->url  }}">{{ $nav_v->name }}</a>
                                    </li>
                                @endif
                            @elseif($nav_v->type === \App\Models\Nav::TYPE_PAGE || \App\Models\Nav::TYPE_LINK)
                                <li class="">
                                    <a href="{{ $nav_v->url  }}">{{ $nav_v->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="blank-div"></div>
    <div class="content-wrapper">
        <div class="container">
            <section class="content">
                <div class="row">
                    @yield('content')
                    <div class="col-md-4 hidden-xs">
                        <div class="row">
                            <div class="box box-widget widget-user">
                                <div class="widget-user-header  bg-black">
                                    <h3 class="widget-user-username">{{ $config['site_admin'] }}</h3>
                                    <h5 class="widget-user-desc">{{ $config['site_admin_info'] }}</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" src="{{  $config['site_admin_avatar'] }}" alt="{{ $config['site_admin'] }}">
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header"><i
                                                        class="fa fa-github-alt"></i></h5>
                                                <span class="description-text"><a class="" href="{{ $config['site_admin_github'] }}">仓库</a></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header"><i
                                                        class="fa fa-weibo"></i></h5>
                                                <span class="description-text"><a class="" href="{{ $config['site_admin_weibo'] }}">微博</a></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header"><i class="fa fa-envelope"></i></h5>
                                                <span class="description-text"><a class="" href="{{ $config['site_admin_mail'] }}">邮箱</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-arrow-up"></i>

                                    <h3 class="box-title">热门文章</h3>
                                </div>
                                <div class="box-body">
                                    <ul class="list-group list-group-unbordered">
                                        @foreach($top_article_list as $article)
                                            <li class="list-group-item">
                                                <i class="fa fa-hand-o-right"></i>
                                                <a href="{{route('article',$article->id)}}"
                                                   class="title-link">{{$article->title}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-tags"></i>

                                    <h3 class="box-title">标签云</h3>
                                </div>
                                <div class="box-body">
                                    @foreach($tag_list as $t_list)
                                        <a href="{{route('tag',$t_list->id)}}" @switch(($t_list->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black" @break @case(1)class="tag btn btn-flat btn-xs bg-olive" @break @case(2)class="tag
                                            btn btn-flat btn-xs bg-blue" @break @case(3)class="tag btn btn-flat btn-xs bg-purple" @break @default class="tag btn btn-flat btn-xs
                                            bg-maroon" @endswitch>{{$t_list->name}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-link"></i>

                                    <h3 class="box-title">友情链接</h3>
                                </div>
                                <div class="box-body">
                                    @foreach( $link_list as $l_list)
                                        <a href="{{$l_list->url}}" class="tag btn btn-flat btn-sm bg-gray" target="_blank">{{$l_list->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-search"></i>

                                    <h3 class="box-title">全站搜索</h3>
                                </div>
                                <div class="box-body">
                                    <form action="{{route('search')}}" method="get">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="keyword" placeholder="搜索">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <a target="_blank" href="{{$config['site_110beian_link']}}" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('img/beian.png')}}" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">{{$config['site_110beian_num']}}</p></a>
                <a target="_blank" href="http://www.miit.gov.cn/" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" ><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">| {{$config['site_icp_num']}}</p></a>
            </div>
            <strong>Copyright &copy; {{date('Y')}}
                <a class="title-link" href="https://imwnk.cn">LABLOG</a>.</strong> All rights reserved.
        </div>
    </footer>
</div>
<!-- jQuery 3 -->
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- OTHER JS SCRIPTS -->
<script left="90%" bottom="5%" text="返回顶部" src="{{asset('js/x-return-top.min.js')}}"></script>
{!! pace_js() !!}
{!! sweetalert2_js() !!}
@include('vendor.message')
@yield('js')
<script>
    var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cspan id='cnzz_stat_icon_{{ env('CNZZ_ANALYTICS_ID') }}'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s13.cnzz.com/z_stat.php%3Fid%3D{{ env('CNZZ_ANALYTICS_ID') }}' type='text/javascript'%3E%3C/script%3E"));
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?{{ env('BD_TONGJI_ID') }}";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https'){
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else{
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
    <!-- Google Analytics -->
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '{{ env("GOOGLE_ANALYTICS_ID") }}', 'auto');
    ga('send', 'pageview');
    <!-- End Google Analytics -->
</script>
</body>

</html>
