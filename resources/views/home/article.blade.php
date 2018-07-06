@extends('layouts.home')
@section('title', $article->title)
@section('keywords', $article->keywords)
@section('description', $article->description)
@section('css')
    {!! social_css() !!}
    {!! highlight_css() !!}
@stop
@section('content')
    <div class="col-sm-8">
        <div class="ibox">
            <div class="ibox-content articleContent">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            @foreach($article->tags as $tag)
                                <a href="{{route('tag',$tag->id)}}"
                                   class="  btn @if(($tag->id)%2==0)btn-white @else btn-info @endif  btn-xs tag"><i
                                        class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center article-title">
                            <h1>
                                {{$article->title}}
                            </h1>
                        </div>
                        <div class="content" style="padding:0;">
                            {!! $article->html !!}
                        </div>
                        <div class="social-share text-center"
                             data-disabled="google,twitter, facebook, diandian,linkedin,douban"></div>
                        <div>
                            <ul class="copyright">
                                <li><strong>本文作者：</strong>{{$article->author}}</li>
                                <li><strong>本文链接：</strong> {{route('article',$article->id)}}
                                </li>
                                <li><strong>版权声明： </strong>本博客所有文章除特别声明外，均采用 <a
                                        href="https://creativecommons.org/licenses/by-nc/4.0/"
                                        rel="external nofollow" target="_blank">CC BY-NC 4.0</a> 许可协议。转载请注明出处！
                                </li>
                            </ul>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="prev-next">
                            <div class="prev pull-left">
                                @if(blank($prev))
                                    {{--<a href="javascript:void(0)" class="btn btn-primary btn-outline btn-block">没有了</a>--}}
                                @else
                                    <a href="{{route('article',$prev['id'])}}"
                                       class="btn btn-primary btn-outline btn-block"><i class="fa fa-arrow-left"></i>&nbsp;{{re_substr($prev['title'],0,8,true)}}
                                    </a>
                                @endif
                            </div>
                            <div class="next pull-right">
                                @if(blank($next))
                                    {{--<a href="javascript:void(0)" class="btn btn-primary btn-outline btn-block">没有了</a>--}}
                                @else
                                    <a href="{{route('article',$next['id'])}}"
                                       class="btn btn-primary btn-outline btn-block">{{re_substr($next['title'],0,8,true)}}&nbsp;<i
                                            class="fa fa-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
            </div>
        </div>
    </div>
@stop
@section('js')
    {!! social_js() !!}
    {!! highlight_js() !!}
<script>
    $(function () {
        $("pre code").each(function(i, block) {
            hljs.highlightBlock(block);
        });
        // 新页面跳转
        $(".content a").attr("target", "_blank");
        $(".content img").addClass('img-responsive');
    });
</script>
@stop
