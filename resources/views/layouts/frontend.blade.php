<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 告诉浏览器该页面是自适应布局 -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE 皮肤。从 css/skins 目录下选择一个皮肤，以减少负载，而不是下载所有皮肤。 -->
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

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.lug.ustc.edu.cn/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-black layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{route('home')}}" class="navbar-brand">
                            <b>{{ $config['site_name'] }}</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse " id="navbar-collapse">
                        <form class="navbar-form navbar-left" role="search" action="{{route('search')}}" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="搜索">
                            </div>
                        </form>

                        <ul class="nav navbar-nav">
                            <li class="">
                                <a href="{{ route('home')}}">首页
                                    <span class="sr-only">（当前）</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">分类
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach($category_list as $c_list)
                                        <li>
                                            <a href="{{route('category',$c_list->id)}}">{{$c_list->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                             <li>
                                <a href="{{route('archive')}}">归档</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">关于
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ $config['site_admin_mail'] }}">邮箱投稿</a>
                                    </li>
                                    <li><a href="{{route('about')}}">关于本站</a></li>
                                </ul>
                            </li>
                             <li>
                                <a href="{{route('message')}}">留言</a>
                            </li>
                        </ul>

                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        @yield('content')
                        <div class="col-md-4 hidden-xs">
                            <div class="row">
                                <div class="box box-widget widget-user">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
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
                                                    <span class="description-text"><a class="" href="{{ $config['site_admin_github'] }}">码云</a></span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header"><i
                                                class="fa fa-weibo"></i></h5>
                                                    <span class="description-text"><a class="" href="{{ $config['site_admin_weibo'] }}">微博</a></span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-4">
                                                <div class="description-block">
                                                    <h5 class="description-header"><i class="fa fa-envelope"></i></h5>
                                                    <span class="description-text"><a class="" href="{{ $config['site_admin_mail'] }}">邮箱</a></span>
                                                </div>
                                                <!-- /.description-block -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-arrow-up"></i>

                                        <h3 class="box-title">热门文章</h3>
                                    </div>
                                    <!-- /.box-header -->
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
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-tags"></i>

                                        <h3 class="box-title">标签云</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        @foreach($tag_list as $t_list)
                                        <a href="{{route('tag',$t_list->id)}}" @switch(($t_list->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black" @break @case(1)class="tag btn btn-flat btn-xs bg-olive" @break @case(2)class="tag
                                            btn btn-flat btn-xs bg-blue" @break @case(3)class="tag btn btn-flat btn-xs bg-purple" @break @default class="tag btn btn-flat btn-xs
                                            bg-maroon" @endswitch>{{$t_list->name}}
                                        </a>
                                        @endforeach
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-link"></i>

                                        <h3 class="box-title">友情链接</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        @foreach( $link_list as $l_list)
                                        <!-- <span class="simple_tag"> -->
                                            <a href="{{$l_list->url}}" class="tag btn btn-flat btn-sm bg-gray" target="_blank">{{$l_list->name}}</a>
                                        <!-- </span> -->
                                        @endforeach
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <i class="fa fa-search"></i>

                                        <h3 class="box-title">全站搜索</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <form action="{{route('search')}}" method="get">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="keyword" placeholder="搜索">
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <a target="_blank" href="{{$config['site_110beian_link']}}" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('img/beian.png')}}" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">{{$config['site_110beian_num']}}</p></a>
                    <a target="_blank" href="http://www.miit.gov.cn/" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" ><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">| {{$config['site_icp_num']}}</p></a>
                </div>
                <strong>Copyright &copy; {{date('Y')}}
                    <a href="https://imwnk.cn">LABLOG</a>.</strong> All rights reserved.
            </div>
            <!-- /.container -->
        </footer>
    </div>
    <!-- ./wrapper -->

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
    @if(Session::has('alertMessage'))
        <script>
            $(function () {
                @if(Session::get('alertType')=='success')
                swal("操作成功", "{{Session::get('alertMessage')}}", "success");
                @else
                swal("操作失败", "{{Session::get('alertMessage')}}", "error");
                @endif
            });
        </script>
    @endif
    @yield('js')
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "{{ env('BAIDU_TONGJI_URL') }}";
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
    </script>
</body>

</html>
