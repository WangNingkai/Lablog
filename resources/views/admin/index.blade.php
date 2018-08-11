@extends('layouts.backend')
@section('title','控制台 - 首页')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>首页<small>LABLOG</small></h1>
        </section>
        <section class="content container-fluid">
            @if (session('status'))
                <div class="callout callout-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            <div class="callout callout-success">
                <h4>您好{{ Auth::user()->name }}，欢迎访问LABLOG</h4>
                <p>在这里您可以尽情的书写你的创意</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
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

                <div class="col-lg-3 col-xs-6">

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

                <div class="col-lg-3 col-xs-6">

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

                <div class="col-lg-3 col-xs-6">

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

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="box box-default">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <h3 class="box-title">最新文章</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>标题</th>
                                    <th>时间</th>
                                </tr>
                                @foreach ($newArticles as $article)
                                <tr>
                                    <td>{{$article->id}}.</td>
                                    <td><a class="text-black" href="{{route('article_edit',$article->id)}}">{{$article->title}}</a></td>
                                    <td>
                                        {{$article->created_at}}
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="{{ route('article_manage') }}" class="btn btn-flat bg-blue pull-right">查看更多</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box box-default">
                        <div class="box-header">
                            <i class="fa fa-comments-o"></i>
                            <h3 class="box-title">最新留言</h3>
                        </div>
                        <div class="box-body chat" id="chat-box">
                            @if(blank($newMessages))
                                <div class="text-center">
                                    <h4>Oops！</h4>
                                    <p>暂无新留言</p>
                                </div>
                            @else
                                @foreach($newMessages as $message)
                            <div class="item">
                                <img src="{{asset('img/user_avatar.png')}}" alt="{{$message->nickname}}" class="online">
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right">
                                            <i class="fa fa-clock-o"></i> {{$message->created_at}}</small>
                                        {{$message->nickname}}
                                    </a>
                                    {{$message->content}}
                                </p>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="box box-default">
                        <div class="box-header">
                            <i class="fa fa-comments-o"></i>
                            <h3 class="box-title">最新评论</h3>
                        </div>
                        <div class="box-body chat" id="chat-box">
                            @if(blank($newComments))
                                <div class="text-center">
                                    <h4>Oops！</h4>
                                    <p>暂无新评论</p>
                                </div>
                            @else
                                @foreach($newComments as $comment)
                                    <div class="item">
                                        <img src="{{asset('img/user_avatar.png')}}" alt="{{$comment->nickname}}" class="online">
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right">
                                                    <i class="fa fa-clock-o"></i> {{$comment->created_at}}</small>
                                                {{$comment->nickname}}
                                            </a>
                                            <span class="text-muted">来自文章：{{$comment->article->title}}</span><br/>
                                            {{$comment->content}}
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
<script src="{{ asset('js/admin.js') }}"></script>
@stop
