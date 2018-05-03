@extends('layouts.home')
@section('title', $config['site_name'])
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-sm-8">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center article-title">
                            <h1>
                                文章归档
                            </h1>
                            <hr/>
                        </div>
                        <div id="vertical-timeline" class="vertical-container dark-timeline ">
                            @foreach($archive as $archive_t)
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon navy-bg">
                                        <i class="fa fa-flag"></i></div>
                                    <div class="vertical-timeline-content">
                                        <h3>{{$archive_t->time}}（共{{$archive_t->posts}}篇）</h3>
                                        <ul class="list-group no-padding">
                                            @foreach($archive_t->articles as $article)
                                                <li class="list-group-item"><a class="btn-link"
                                                                               href="{{route('article',$article->id)}}">{{$article->title}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
