@extends('layouts.frontend')
@section('title', '搜索')
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-md-8">
        @if(blank($articles))
            <div class="callout callout-danger">
                <h4>Oops！</h4>
                <p>未找到相关文章</p>
            </div>
        @else
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @if(blank(request()->input('keyword')))
                            <h3>
                                <span class="text-red">请输入条件进行查询</span>
                            </h3>
                        @else
                            <h3>
                                为您找到相关结果约{{$articles->count}}个： <span class="text-blue">“{{request()->input('keyword')}}
                                    ”</span>
                            </h3>
                        @endif
                        <div class="search-form">
                            <form action="{{route('search')}}" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{request()->input('keyword')}}" name="keyword">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-flat bg-black">搜索</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @foreach($articles as $article)
                            <div class="hr-line-dashed"></div>
                            <div class="search-result">
                                <h3><a href="{{route('article',$article->id)}}" class="title-link">{{$article->title}}</a></h3>
                                <a href="{{route('article',$article->id)}}"
                                class="search-link">{{route('article',$article->id)}}</a>
                                <div class="description">
                                    <p style="word-wrap:break-word;">{{$article->description}}</p>
                                </div>
                            </div>
                        @endforeach
                        {{$articles->appends(['keyword' => request()->input('keyword')])->links()}}
                    </div>
                </div>

            </div>
          <!-- /.box-body -->
        </div>
        @endif
    </div>
@stop
@section('js')

@stop
