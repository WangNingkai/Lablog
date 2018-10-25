@extends('layouts.frontend')
@section('title', '分享站点')
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('css')
    <link rel="stylesheet" href="{{ asset('css/markdown.css') }}">
@stop
@section('content')
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('home')}}" class="btn bg-black btn-flat btn-sm tag pull-left"><i
                                class="fa fa-undo"></i>&nbsp;返回首页</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3>
                                分享站点
                            </h3>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="markdown-body" style="word-wrap:break-word;">
                            <ul>
                                @foreach($links as $link)
                                    <li><a href="{{ $link->url }}">{{ $link->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
