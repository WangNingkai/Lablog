<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/skin-blue.min.css')}}">
    <!-- OTHER stylesheet -->
    {!! pace_css('white') !!}
    <!-- SweetAlert2  -->
    {!! sweetalert2_css() !!}
    @yield('css')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- 警告：Respond.js 不支持 file:// 方式查看（即本地方式查看）-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.loli.net/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- 主要头部 -->
    <header class="main-header">
        <!-- Logo -->
        <a href="{{route('home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Dash</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">LABLOG - 控制台</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">切换导航</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('home') }}" target="_blank"><i class="fa fa-home"></i>&nbsp;查看首页</a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $config['site_admin_avatar'] }}" class="user-image" alt="{{ $config['site_admin'] }}">
                            <!-- hidden-xs 在小型设备上隐藏用户名，只显示图像。 -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ $config['site_admin_avatar'] }}" class="img-circle"
                                     alt="{{ $config['site_admin'] }}">
                                <p>
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-center">{{ $config['site_admin_info'] }}</p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <p>登陆时间 ：{{Auth::user()->last_login_at}}</p>
                                <p>登陆地点 ：{{ip_to_city(Auth::user()->last_login_ip)}}</p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('profile_manage') }}" class="btn btn-default btn-flat">资料</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">退出</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- 左侧边栏. 包括LOGO和菜单栏 -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- 用户面板 (可选择) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ $config['site_admin_avatar'] }}" class="img-circle" alt="{{ $config['site_admin'] }}">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- 状态 -->
                    <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
                </div>
            </div>

            <!-- 搜索栏 (可选择) -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="搜索...">
                    <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- 侧边菜单栏 -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">菜单</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="{{ set_active('admin/home') }}"><a href="{{ route('dashboard_home') }}"><i class="fa fa-home"></i> <span>首页</span></a></li>
                <li class="{{ set_active('article/create') }}"><a href="{{ route('article_create') }}"><i class="fa fa-pencil-square-o"></i> <span>新建文章</span></a></li>
                <!-- <li><a href="#"><i class="fa fa-cog"></i> <span></span></a></li> -->
                <li class="treeview {{ set_active('admin/config') }} {{ set_active('admin/about') }}">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>我的站点</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ set_active('admin/config/manage') }}" ><a href="{{ route('config_manage') }}"><i class="fa fa-cog"></i> 站点设置</a></li>
                        <li class="{{ set_active('admin/about/manage') }}"><a href="{{ route('about_manage') }}"><i class="fa fa-address-card"></i> 关于页面</a></li>
                    </ul>
                </li>
                <li class="treeview {{ set_active('admin/tag') }} {{ set_active('admin/category') }} {{ set_active('admin/article') }}">
                    <a href="#">
                        <i class="fa fa-book"></i> <span>内容管理</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ set_active('admin/tag/manage') }}"><a href="{{ route('tag_manage') }}"><i class="fa fa-tags"></i> 标签管理</a></li>
                        <li class="{{ set_active('admin/category') }}"><a href="{{ route('category_manage') }}"><i class="fa fa-bars"></i> 栏目管理</a></li>
                        <li class="{{ set_active('admin/article/manage') }}"><a href="{{ route('article_manage') }}"><i class="fa fa-file"></i> 文章管理</a></li>
                        <li class="{{ set_active('admin/article/trash') }}"><a href="{{ route('article_trash') }}"><i class="fa fa-trash"></i> 文章回收站</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cogs"></i> <span>其他模块</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('link_manage') }}"><i class="fa fa-link"></i>
                        我的友链</a></li>
                        <li><a href="{{ route('message_manage') }}"><i class="fa fa-comments"></i> 我的留言</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('operation_logs_manage') }}"><i class="fa fa-history"></i> <span>操作日志</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    @yield('content')

    <!-- 主要页脚区 -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <a target="_blank" href="{{$config['site_110beian_link']}}" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="{{asset('img/beian.png')}}" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">{{$config['site_110beian_num']}}</p></a>
            <a target="_blank" href="http://www.miit.gov.cn/" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" ><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">| {{$config['site_icp_num']}}</p></a>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ date('Y') }} <a href="#">LABLOG</a>.</strong> All rights reserved.
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
<!-- SweetAlert2  -->
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
</body>
</html>
