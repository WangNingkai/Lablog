@extends('layouts.home')
@section('title', '搜索')
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-sm-8">
        <div class="ibox">
            <div class="ibox-content">
                @if(blank($articles))
                    <div class="alert alert-danger alert-dismissable text-center">
                        <h2>Ops,未找到相关文章</h2>
                    </div>
                @else
                    @if(blank(request()->input('keyword')))
                        <h2>
                            <span class="text-danger">请输入条件进行查询</span>
                        </h2>
                    @else
                        <h2>
                            为您找到相关结果约{{$articles->count}}个： <span class="text-navy">“{{request()->input('keyword')}}
                                ”</span>
                        </h2>
                    @endif

                    <div class="search-form">
                        <form action="{{route('search')}}" method="get">
                            <div class="input-group">
                                <input type="text" placeholder="{{request()->input('keyword')}}" name="keyword"
                                       class="form-control input-lg">
                                <div class="input-group-btn">
                                    <button class="btn btn-lg btn-primary" type="submit">搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @foreach($articles as $article)
                        <div class="hr-line-dashed"></div>
                        <div class="search-result">
                            <h3><a href="{{route('article',$article->id)}}">{{$article->title}}</a></h3>
                            <a href="{{route('article',$article->id)}}"
                               class="search-link">{{route('article',$article->id)}}</a>
                            <p>
                                {{$article->description}}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
@section('js')

@stop
