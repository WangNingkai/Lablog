@extends('layouts.backend')
@section('title','控制台')
@section('content')
    <!-- 主内容区. 包括页面 -->
    <div class="content-wrapper">
        <!-- Content Header (页眉) -->
        <section class="content-header">
            <h1>首页<small>LABLOG</small></h1>
            <!-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 层级</a></li>
                <li class="active">这里</li>
            </ol> -->
        </section>

        <!-- 主内容区 -->
        <section class="content container-fluid">
            @if (session('status'))
                <div class="callout callout-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            <div class="callout callout-success">
                <h4>您好{{ Auth::user()->name }}，欢迎访问LABLOG</h4>
                <p>在这里您可以尽情的书写你的创意</p>
                <p>登陆时间 ：{{Auth::user()->last_login_at}}</p>
                <p>登陆地点 ：{{ip_to_city(Auth::user()->last_login_ip)}}</p>
            </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $allArticlesCount }}</h3>

                            <p>我的文章</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clipboard"></i>
                        </div>
                        <a href="{{ route('article_manage') }}" class="small-box-footer">更多信息
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $allCategoriesCount }}</h3>

                            <p>我的栏目</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-navicon-round"></i>
                        </div>
                        <a href="{{ route('category_manage') }}" class="small-box-footer">更多信息
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $allTagsCount }}</h3>

                            <p>我的标签</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pricetags"></i>
                        </div>
                        <a href="{{ route('tag_manage') }}" class="small-box-footer">更多信息
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $allMessagesCount }}</h3>

                            <p>我的留言</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-chatbubbles"></i>
                        </div>
                        <a href="{{ route('message_manage') }}" class="small-box-footer">更多信息
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <!-- TO DO List -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <h3 class="box-title">最新文章</h3>
                        </div>
                        <div class="box-body">
                            <ul class="todo-list">
                                @foreach($newArticles as $article)
                                    <li>
                                        <span class="text"><a href="{{route('article_edit',$article->id)}}">{{$article->title}}</a></span>
                                        <small class="label label-info">
                                            <i class="fa fa-clock-o"></i> {{transform_time($article->updated_at)}}</small>
                                        <div class="tools">
                                            <i class="fa fa-edit"></i>
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-border">
                            <a href="" class="btn btn-default pull-right">
                                <i class="fa fa-plus"></i> 添加文章</a>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')

@endsection
