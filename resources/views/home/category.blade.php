@extends('layouts.frontend')
@section('title', $category->name)
@section('keywords', $category->keywords)
@section('description', $category->description)
@section('content')
<div class="row">
    <div class="col-md-8">
        @if(blank($articles))
            <div class="callout callout-danger">
                <h4>Oops！</h4>
                <p>未找到相关文章</p>
            </div>
        @else
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">栏目：<span class="text-red">{{$category->name}}</span</h3>
            </div>
            <div class="box-body">
                <p>@foreach($childCategoryList as $childCategory)<a href="{{route('category',$childCategory->id)}}" class="btn btn-flat bg-blue tag">{{$childCategory->name}}</a>@endforeach</p>
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
                                <a href="{{route('tag',$tag->id)}}" @switch(($tag->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black" @break @case(1)class="tag btn btn-flat btn-xs bg-olive" @break @case(2)class="tag btn btn-flat btn-xs bg-blue" @break @case(3)class="tag btn btn-flat btn-xs bg-purple" @break @default class="tag btn btn-flat btn-xs bg-maroon" @endswitch><i class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
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
                                <a href="{{route('article',$article->id)}}" class="btn btn-flat bg-black tag"><i class="fa fa-eye"></i> 阅读全文</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$articles->links()}}
        @endif
    </div>
    @include('layouts.frontend-sider')
</div>
@stop
