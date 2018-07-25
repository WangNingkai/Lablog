@extends('layouts.frontend')
@section('title', '关于本站')
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('content')
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                         <a href="{{route('home')}}" class="btn bg-black btn-flat btn-sm tag pull-left"><i class="fa fa-undo"></i>&nbsp;返回</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                        <h3>
                            关于本站
                        </h3>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="content" style="">
                            {!! markdown_to_html($config['site_about']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $(".content img").addClass('img-responsive');
        });
    </script>
@stop
