@extends('layouts.home')
@section('title', $category->name)
@section('keywords', $category->keywords)
@section('description', $category->description)
@section('content')
    <div class="col-sm-8">
        @if(blank($articles))
            <div class="alert alert-danger alert-dismissable text-center">
                <h1>Ops,未找到相关文章</h1>
            </div>
        @else
            <div class="article-list">
                <div class="ibox">
                    <div class="ibox-content page-heading">
                        <h2>栏目：{{$category->name}}</h2>
                        <p>@foreach($childCategoryList as $childCategory)
                        <span class="simple_tag"><a href="{{route('category',$childCategory->id)}}" target="_blank">{{$childCategory->name}}</a></span>
                        @endforeach</p>
                    </div>
                </div>
                @foreach($articles as $article)
                    <div class="ibox">
                        <div class="ibox-content">
                            <a href="{{route('article',$article->id)}}" class="btn-link">
                                <h2>
                                    {{$article->title}}
                                </h2>
                            </a>
                            <div class="small m-b-xs">
                                <strong>{{$article->author}}</strong>&nbsp;&nbsp;<span class="text-muted"><i
                                        class="fa fa-clock-o"></i>&nbsp;最后更新于&nbsp;{{transform_time($article->created_at)}}</span>
                            </div>
                            <p>
                                {{$article->description}}
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>标签：</h5>
                                    @foreach($article->tag as $tag)
                                        <a href="{{route('tag',$tag->tag_id)}}"
                                           class="  btn @if(($tag->tag_id)%2==0)btn-white @else btn-info @endif  btn-xs tag"><i
                                                class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-right">
                                        <h5>状态：</h5>
                                        <div><i class="fa fa-comments-o"> </i> 0 评论</div>
                                        <i class="fa fa-eye"> </i> {{$article->click}} 浏览
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4 pull-right">
                                    <a href="{{route('article',$article->id)}}" class="btn btn-primary tag"><i
                                            class="fa fa-eye"></i> 阅读全文</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$articles->links()}}
            </div>
        @endif
    </div>
@stop
