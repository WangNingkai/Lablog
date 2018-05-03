<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>主页</title>
    @section('css')
        <link href="{{asset('tpl/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('tpl/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('tpl/css/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('tpl/css/style.min.css')}}" rel="stylesheet">
        <script>
            var indexUrl = "{{route('dashboard')}}";
        </script>
    @show
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <!--顶部通知-->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content text-center p-md">
                    <h2>
                        <span class="text-navy">W.NK博客后台管理</span>
                    </h2>
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <p>欢迎您登陆
                            <a class="alert-link" href="">{{ Auth::user()->name }}</a>.</p>

                        <p>登陆时间 ：{{Auth::user()->last_login_at}}</p>
                        <p>登陆地点 ：{{Auth::user()->last_login_ip}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--最新发表-->
    <div class="row">
        <div class="col-sm-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>最新发表</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="list-group">
                        @if(!blank($newArticles))
                            @foreach($newArticles as $article)
                                <a class="list-group-item" href="{{route('article_edit',$article->id)}}">
                                    <h3 class="list-group-item-heading">{{$article->title}}</h3>
                                    <p class="list-group-item-text">{{$article->description}}</p>
                                    <p>{{transform_time($article->updated_at)}}</p>
                                </a>
                            @endforeach
                        @else
                            <h2>ops,暂无相关文章！</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>快捷操作</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div>
                        <a href="{{route('article_add')}}" class="btn btn-block btn-outline btn-primary">发布文章</a>
                    </div>
                    <div>
                        <a href="{{route('config_manage')}}" class="btn btn-block btn-outline btn-primary">网站设置</a>
                    </div>
                    <div>
                        <a href="{{route('link_manage')}}" class="btn btn-block btn-outline btn-primary">友链设置</a>
                    </div>
                    <div>
                        <a href="{{route('message_manage')}}" class="btn btn-block btn-outline btn-primary">留言管理</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script src="{{asset('tpl/js/jquery.min.js')}}"></script>
    <script src="{{asset('tpl/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('tpl/js/content.min.js')}}"></script>
    <script left="85%" bottom="10%" text="返回顶部" src="{{asset('tpl/js/returnTop.js')}}"></script>
@show
</body>

</html>
