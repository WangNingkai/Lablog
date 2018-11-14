@extends('layouts.frontend')
@section('title', $config['site_title'])
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-bullhorn"></i>

                <h3 class="box-title">网站公告</h3>
            </div>
            <div class="box-body">
                <p>{{$config['site_info']}}</p>
            </div>
        </div>
        @foreach($articles as $article)
            <div class="box box-solid">
                <div class="box-body article-body">
                    @if($article->is_top)
                        <small>🔥🔥🔥&nbsp;&nbsp;</small>
                    @endif
                    <a href="{{route('article',$article->id)}}" class="title-link">
                        <h3>
                            {{ $article->title }}
                        </h3>
                    </a>
                    <div class="small m-b-xs">
                        <strong>{{$article->author}}</strong>&nbsp;&nbsp;<span class="text-muted"><i
                                class="fa fa-clock-o"></i>&nbsp;最后更新于&nbsp;{{\App\Helpers\Extensions\Tool::transformTime($article->feed_updated_at)}}</span>
                    </div>
                    <div class="description">
                        <p style="word-wrap:break-word;">{{$article->description}}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>标签：</h5>
                            @foreach($article->tags as $tag)
                                <a href="{{route('tag',$tag->id)}}"
                                   @switch(($tag->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black"
                                   @break @case(1)class="tag btn btn-flat btn-xs bg-olive"
                                   @break @case(2)class="tag btn btn-flat btn-xs bg-blue"
                                   @break @case(3)class="tag btn btn-flat btn-xs bg-purple"
                                   @break @default class="tag btn btn-flat btn-xs bg-maroon" @endswitch><i
                                        class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="small text-right">
                                <h5>状态：</h5>
                                <div><i class="fa fa-comments-o"> </i> {{ $article->comment_count }} 评论</div>
                                <i class="fa fa-eye"> </i> {{$article->click}} 浏览
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <a href="{{route('article',$article->id)}}" class="btn btn-flat bg-black tag"><i
                                        class="fa fa-eye"></i> 阅读全文</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $articles->links() }}
    </div>
@stop
