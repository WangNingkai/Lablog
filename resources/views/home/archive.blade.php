@extends('layouts.frontend')
@section('title', '文章归档')
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-md-8">
        <ul class="timeline">
            @foreach($archive as $archive_t)
                <li class="time-label">
                    <span class="bg-black">
                        {{$archive_t->time}}（共{{$archive_t->posts}}篇）
                    </span>
                </li>

                    <li>
                        <i class="fa fa-flag bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time">
                                <i class="fa fa-clock-o"></i> {{$archive_t->time}}</span>

                            <h3 class="timeline-header">{{$archive_t->time}} 共{{$archive_t->posts}}篇文章</h3>

                            <div class="timeline-body">
                                <ul class="list-group list-group-unbordered">
                                    @foreach($archive_t->articles as $article)
                                        <li class="list-group-item">
                                            <a href="{{route('article',$article->id)}}" class="title-link"><i class="fa fa-circle-o"></i>&nbsp;{{$article->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="timeline-footer">
                                <!-- <a class="btn btn-primary btn-xs">阅读更多</a>
                                <a class="btn btn-danger btn-xs">删除</a> -->
                            </div>
                        </div>
                    </li>
                @endforeach
            <div class="text-center" >
                {{ $archive->links() }}
            </div>
        </ul>
    </div>
@stop
