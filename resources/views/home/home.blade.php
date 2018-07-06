@extends('layouts.frontend')
@section('title', $config['site_name'])
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
<div class="col-md-8">
    <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>

            <h3 class="box-title">网站公告</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <p>{{$config['site_info']}}</p>
        </div>
        <!-- /.box-body -->
    </div>
    @foreach($articles as $article)
        <div class="box box-solid">
            <div class="box-body">
                <a href="{{route('article',$article->id)}}" class="title-link">
                    <h3>
                        {{$article->title}}
                    </h3>
                </a>
                <div class="small m-b-xs">
                    <strong>{{$article->author}}</strong>&nbsp;&nbsp;<span class="text-muted"><i class="fa fa-clock-o"></i>&nbsp;最后更新于&nbsp;{{transform_time($article->created_at)}}</span>
                </div>
                <p>
                    {{$article->description}}
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <h5>标签：</h5>
                        @foreach($article->tags as $tag)
                            <a href="{{route('tag',$tag->id)}}" class="btn btn-default btn-xs tag"><i class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        <div class="small text-right">
                            <h5>状态：</h5>
                            <i class="fa fa-eye"> </i> {{$article->click}} 浏览
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <a href="{{route('article',$article->id)}}" class="btn btn-default tag"><i class="fa fa-eye"></i> 阅读全文</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{$articles->links()}}
</div>

@stop
