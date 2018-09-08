@extends('layouts.frontend')
@section('title', $article->title)
@section('keywords', $article->keywords)
@section('description', $article->description)
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/prismjs@1/themes/prism-okaidia.min.css,npm/prismjs@1/plugins/toolbar/prism-toolbar.min.css,npm/prismjs@1/plugins/previewers/prism-previewers.min.css,npm/prismjs@1/plugins/command-line/prism-command-line.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/social-share.js@1/dist/css/share.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.css">
@stop
@section('content')
    <div class="col-md-8">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <a href="{{route('home')}}" class="btn bg-black btn-flat btn-sm tag"><i class="fa fa-undo"></i>&nbsp;返回</a>
                        </div>
                        <div class="pull-right">
                            @foreach($article->tags as $tag)
                                <a href="{{route('tag',$tag->id)}}" @switch(($tag->id)%5) @case(0)class="tag btn btn-flat btn-xs bg-black" @break @case(1)class="tag btn btn-flat btn-xs bg-olive" @break @case(2)class="tag btn btn-flat btn-xs bg-blue" @break @case(3)class="tag btn btn-flat btn-xs bg-purple" @break @default class="tag btn btn-flat btn-xs bg-maroon" @endswitch target="_blank"><i class="fa fa-tag"></i>&nbsp;{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center article-title">
                            <h2>
                                {{$article->title}}
                            </h2>
                        </div>
                        <div class="content article-content" style="word-wrap:break-word;">
                            {!! $article->feed->html !!}
                        </div>
                        @if ($config['allow_reward'] == 1)
                            <div class="text-center">
                                <a class="btn bg-red" data-toggle="collapse" href="#reward" role="button" aria-expanded="false" aria-controls="reward">赏</a>
                            </div>
                            <div class="collapse text-center " id="reward">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4"><img src="{{ $config['wepay'] }}" alt="微信打赏" class="img-responsive"><span class="help-block">微信打赏</span></div>
                                    <div class="col-md-4"><img src="{{ $config['alipay'] }}" alt="支付宝打赏" class="img-responsive"><span class="help-block">支付宝打赏</span></div>
                                    <div class="col-md-2"></div>
                                </div>

                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif
                        <div class="social-share text-center"
                             data-disabled="google,twitter, facebook, diandian,linkedin,douban"></div>
                        <div class="copyright_div">
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
                                @else
                                    <a href="{{route('article',$prev['id'])}}" class="btn bg-black btn-flat btn-block" title="{{ $prev->title }}">
                                        <i class="fa fa-arrow-left"></i>&nbsp;{{ \App\Helpers\Extensions\Tool::subStr($prev['title'],0,10,true)}}
                                    </a>
                                @endif
                            </div>
                            <div class="next pull-right">
                                @if(blank($next))
                                @else
                                    <a href="{{route('article',$next['id'])}}" class="btn bg-black btn-flat btn-block" title="{{ $next->title }}">
                                        {{\App\Helpers\Extensions\Tool::subStr($next['title'],0,10,true)}}&nbsp;<i class="fa fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @if($article->allow_comment == \App\Models\Article::FORBID_COMMENT || $config['site_allow_comment'] == 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="post clearfix">
                                <h4 class="text-bold">评论已关闭</h4>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="post clearfix">
                                <h4 class="text-bold">评论：</h4>
                                @include('errors.validator')
                                <form role="form" action="{{route('comment_store')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="article_id" id="article_id" value="{{$article->id}}">
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            <textarea class="form-control" style="resize: none;" rows="3" cols="4" name="content" placeholder="请输入评论" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <input type="text" class="form-control" name ="nickname" placeholder="输入评论显示名称 *" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <input type="email" class="form-control" name="email" placeholder="输入电子邮件（不会显示）*" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <button type="submit" class="btn btn-flat btn-block bg-green">评论</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @foreach($article->comments as $comment)
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{asset('img/user_avatar.png')}}" alt="{{$comment->nickname}}">
                                        <span class="username">
                                <a href="#">{{ $comment->nickname }}</a>
                                </span>
                                        <span class="description">{{ $comment->created_at }}</span>
                                    </div>
                                    <p>
                                        {{ $comment->content }}
                                    </p>
                                    @isset($comment->reply)
                                        <div class="post reply-post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="{{ $config['site_admin_avatar'] }}" alt="{{ $config['site_admin'] }}">
                                                <span class="username">
                                            <a href="#">站长回复</a>
                                        </span>
                                                <span class="description">{{ $comment->updated_at }}</span>
                                            </div>
                                            <p>
                                                {{ $comment->reply }}
                                            </p>
                                        </div>
                                    @endisset
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/combine/npm/prismjs@1,npm/prismjs@1/components/prism-markup-templating.min.js,npm/prismjs@1/components/prism-markup.min.js,npm/prismjs@1/components/prism-css.min.js,npm/prismjs@1/components/prism-clike.min.js,npm/prismjs@1/components/prism-javascript.min.js,npm/prismjs@1/components/prism-docker.min.js,npm/prismjs@1/components/prism-git.min.js,npm/prismjs@1/components/prism-json.min.js,npm/prismjs@1/components/prism-less.min.js,npm/prismjs@1/components/prism-markdown.min.js,npm/prismjs@1/components/prism-nginx.min.js,npm/prismjs@1/components/prism-php.min.js,npm/prismjs@1/components/prism-php-extras.min.js,npm/prismjs@1/components/prism-sass.min.js,npm/prismjs@1/components/prism-sql.min.js,npm/prismjs@1/components/prism-yaml.min.js,npm/prismjs@1/components/prism-bash.min.js,npm/prismjs@1/components/prism-ini.min.js,npm/prismjs@1/plugins/toolbar/prism-toolbar.min.js,npm/prismjs@1/plugins/previewers/prism-previewers.min.js,npm/prismjs@1/plugins/autoloader/prism-autoloader.min.js,npm/prismjs@1/plugins/command-line/prism-command-line.min.js,npm/prismjs@1/plugins/normalize-whitespace/prism-normalize-whitespace.min.js,npm/prismjs@1/plugins/keep-markup/prism-keep-markup.min.js,npm/prismjs@1/plugins/show-language/prism-show-language.min.js,npm/prismjs@1/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/social-share.js@1/dist/js/jquery.share.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.js"></script>
    <script>
        $(function () {
            $(".article-content  img").addClass("img-responsive");
            // 判断父类是否是a标签 是添加data属性 否添加a标签
            if($(".article-content  img").parent().is("a"))
            {
                $(".article-content  img").parent().attr("data-fancybox","article-content");
            }
            $(".article-content  table").addClass("table table-hover table-bordered");
            $("[data-fancybox]").fancybox();
        });
    </script>
@stop
