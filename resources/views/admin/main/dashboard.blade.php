<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>控制台</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
    {!! bootstrap_css() !!}
    {!! fontawesome_css() !!}
    {!! animate_css() !!}
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    {!! sweetalert2_css() !!}
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close">
            <i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
							<span>
								<img alt="image" class="img-circle" src="{{asset('tpl/img/admin_avatar.png')}}"
                                     width="64"
                                     height="64"/>
							</span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="clear">
									<span class="block m-t-xs">
										<strong class="font-bold">{{ Auth::user()->name }}</strong>
									</span>
									<span class="text-muted text-xs block">个人管理
										<b class="caret"></b>
									</span>
								</span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <a class="J_menuItem" href="{{route('profile_manage')}}">个人资料</a>
                            </li>
                            <li>
                                <a href="{{route('cache_clear')}}">清理缓存</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">安全退出</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </div>
                    <div class="logo-element">BLOG
                    </div>
                </li>
                <li>
                    <a class="J_menuItem" href="{{route('config_manage')}}">
                        <i class="fa fa fa-cog"></i>
                        <span class="nav-label">网站配置</span>
                    </a>
                </li>
                <li>
                    <a class="J_menuItem" href="{{route('about_edit')}}">
                        <i class="fa fa-address-card"></i>
                        <span class="nav-label">关于站点</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span class="nav-label">内容管理</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('tag_manage') }}">标签管理</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('category_manage') }}">栏目管理</a>
                        </li>
                        <li>
                            <a href="#">文章管理
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="J_menuItem" href="{{ route('article_add') }}">新文章</a>
                                </li>
                                <li>
                                    <a class="J_menuItem" href="{{ route('article_manage') }}">全部文章</a>
                                </li>

                                <li>
                                    <a class="J_menuItem" href="{{ route('article_trash') }}">已删除文章</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span class="nav-label">其他模块</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('link_manage') }}">友链管理</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('message_manage') }}">留言管理</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="hidden-xs">
                        <a href="{{ route('home') }}" target="_blank">
                            <i class="fa fa-home"></i> 查看前台</a>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a class="right-sidebar-toggle" aria-expanded="false">
                            <i class="fa fa-cog"></i>设置
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="{{route('admin_home')}}">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight">
                <i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">
                    <i class="fa fa-list-ul"></i> 选项
                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabGo">
                        <a>前进</a>
                    </li>
                    <li class="J_tabBack">
                        <a>后退</a>
                    </li>
                    <li class="J_tabFresh">
                        <a>刷新</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabShowActive">
                        <a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll">
                        <a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther">
                        <a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('logout') }}" class="roll-nav roll-right J_tabExit"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{route('admin_home')}}"
                    frameborder="0" data-id="{{route('admin_home')}}"
                    seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">
            <div class="sidebar-title">
                <h3> 主题设置</h3>
                <small>
                    <i class="fa fa-tim"></i> 选择和预览主题的布局和样式
                </small>
            </div>
            <div class="skin-setttings">
                <div class="title">主题设置</div>
                <div class="setings-item">
                    <span>收起左侧菜单</span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                            <label class="onoffswitch-label" for="collapsemenu">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
                    <span>固定顶部</span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                            <label class="onoffswitch-label" for="fixednavbar">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
						<span>
							固定宽度
						</span>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                            <label class="onoffswitch-label" for="boxedlayout">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="title">皮肤选择</div>
                <div class="setings-item default-skin nb">
						<span class="skin-name ">
							<a href="#" class="s-skin-0">
								默认皮肤
							</a>
						</span>
                </div>
                <div class="setings-item blue-skin nb">
						<span class="skin-name ">
							<a href="#" class="s-skin-1">
								蓝色主题
							</a>
						</span>
                </div>
                <div class="setings-item yellow-skin nb">
						<span class="skin-name ">
							<a href="#" class="s-skin-3">
								黄色/紫色主题
							</a>
						</span>
                </div>
            </div>
        </div>
    </div>
    <!--右侧边栏结束-->
</div>
{!! jquery_js() !!}
{!! bootstrap_js() !!}
<script src="{{asset('tpl/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
{!! scroll_js() !!}
<script src="{{asset('tpl/plugins/layer/layer.min.js')}}"></script>
<script src="{{asset('tpl/js/hplus.min.js')}}"></script>
<script src="{{asset('tpl/js/contabs.min.js')}}"></script>
{!! pace_js() !!}
</body>

</html>
