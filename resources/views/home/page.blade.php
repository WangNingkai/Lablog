@extends('layouts.frontend')
@section('title', $page->title)
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('css')
    {!! highlight_css() !!}
    {!! fancybox_css() !!}
@stop
@section('content')
    <div class="col-md-8">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('home')}}" class="btn bg-black btn-flat btn-sm tag pull-left"><i class="fa fa-undo"></i>&nbsp;返回首页</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3>
                                {{ $page->title }}
                            </h3>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="content" style="">
                            {!! $page->feed->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    {!! highlight_js() !!}
    {!! fancybox_js() !!}
    <script>
        $(function () {
            $("pre code").each(function(i, block) {
                hljs.highlightBlock(block);
            });
            $(".content  img").addClass("img-responsive");
            // 判断父类是否是a标签 是添加data属性 否添加a标签
            if($(".content  img").parent().is("a"))
            {
                $(".content  img").parent().attr("data-fancybox","article-content");
            }
            $(".content  table").addClass("table table-hover table-bordered");
            $("[data-fancybox]").fancybox();
        });
    </script>
@stop
