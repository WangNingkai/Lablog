<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="description" content="@yield('description')"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! bootstrap_css() !!}
    {!! fontawesome_css() !!}
    {!! animate_css() !!}
    <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
    {!! sweetalert2_css() !!}
    <link href="{{asset('tpl/custome/css/home.custome.css')}}" rel="stylesheet">
    @yield('css')
</head>

<body class="gray-bg top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <!--导航栏  -->
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <a href="{{route('home')}}" class="navbar-brand">{{ config('app.name', 'LABLOG') }}</a>
                </div>
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a aria-expanded="false" role="button" href="{{route('home')}}">首页</a>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" role="button" href="#" class="dropdown-toggle"
                               data-toggle="dropdown">分类 <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                @foreach($category_list as $c_list)
                                    <li>
                                        <a href="{{route('category',$c_list->id)}}">{{$c_list->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="">
                            <a href="{{route('archive')}}">归档</a>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" role="button" href="#" class="dropdown-toggle"
                               data-toggle="dropdown">关于<span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li>
                                    <a href="{{ $config['site_admin_mail'] }}">邮箱投稿</a>
                                </li>
                                <li><a href="{{route('about')}}">关于本站</a></li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="{{route('message')}}">留言</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--导航栏  -->
        <div class="wrapper wrapper-content main-content">
            <div class="row">
                <!--内容  -->
                @yield('content')
                <!--/内容  -->
                <!--侧边栏  -->
                <div class="col-sm-4 sider-info">
                    <!--个人信息  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading text-left">
                                    <i class="fa fa-id-card-o"></i>&nbsp;&nbsp;联系我
                                </div>
                                <div class="panel-body">
                                    <h3><strong>{{ $config['site_admin'] }}</strong></h3>
                                    {{--<img src="" alt="{{ $config['site_admin'] }}" class="img-circle">--}}
                                    <h4>{{ $config['site_admin_info'] }}</h4>
                                    <hr/>
                                    <a class="btn btn-success btn-circle" href="{{ $config['site_admin_github'] }}"><i
                                            class="fa fa-github-alt"></i></a>
                                    <a class="btn btn-info btn-circle" href="{{ $config['site_admin_weibo'] }}"><i
                                            class="fa fa-weibo"></i></a>
                                    <a class="btn btn-warning btn-circle" href="{{ $config['site_admin_mail'] }}"><i class="fa fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--置顶文章  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-arrow-up"></i>&nbsp;&nbsp;热门文章
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group no-padding">
                                        @foreach($article_list as $article)
                                            <li class="list-group-item">
                                                <i class="fa fa-hand-o-right"></i>
                                                <a href="{{route('article',$article->id)}}"
                                                   class="btn-link">{{$article->title}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--标签云  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-tags"></i>&nbsp;&nbsp;标签云
                                </div>
                                <div class="panel-body">
                                    @foreach($tag_list as $t_list)
                                        <a href="{{route('tag',$t_list->id)}}"
                                           @switch(($t_list->id)%5)
                                           @case(0)class="tag btn btn-xs btn-info"
                                           @break
                                           @case(1)class="tag btn btn-xs btn-danger"
                                           @break
                                           @case(2)class="tag btn btn-xs btn-primary"
                                           @break
                                           @case(3)class="tag btn btn-xs btn-success"
                                           @break
                                           @default class="tag btn btn-xs btn-warning"
                                            @endswitch>{{$t_list->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--友情链接  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-link"></i>&nbsp;&nbsp;友情链接
                                </div>
                                <div class="panel-body">
                                    @foreach( $link_list as $l_list)
                                        <span class="simple_tag"><a href="{{$l_list->url}}" target="_blank">{{$l_list->name}}</a></span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--站点搜索  -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-search"></i>&nbsp;&nbsp;全站搜索
                                </div>
                                <div class="panel-body">
                                    <form action="{{route('search')}}" method="get">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="keyword" placeholder="搜索">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--站点推广  -->
                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-search"></i>&nbsp;&nbsp;推广链接
                                </div>
                                <div class="panel-body">
                                    <a href="https://www.upyun.com/"><img class="img-responsive" src="{{asset('img/upy_logo.png')}}" alt="又拍云"></a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!--/侧边栏  -->
            </div>
        </div>
        <!--页脚  -->
        <div class="footer">
            <div class="pull-right">
                <a target="_blank" href="{{$config['site_110beian_link']}}" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="https://share.imwnk.cn/Images/2018/07/04/beian.png" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">{{$config['site_110beian_num']}}</p></a>
                <a target="_blank" href="http://www.miit.gov.cn/" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;" ><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">| {{$config['site_icp_num']}}</p></a>
            </div>
            <div class="sider-info">
                &copy; {{ date('Y') }} {{ config('app.name') }}.
            </div>
        </div>
        <!--页脚  -->
    </div>
</div>
{!! jquery_js() !!}
{!! bootstrap_js() !!}
{!! pace_js() !!}
{!! sweetalert2_js() !!}
<script left="87%" bottom="6%" text="返回顶部" src="{{asset('tpl/js/returnTop.js')}}"></script>

@if(Session::has('alertMessage'))
    <script>
        $(function () {
            @if(Session::get('alertType') == 'success')
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
