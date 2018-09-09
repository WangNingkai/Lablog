@extends('layouts.frontend')
@section('title', $page->title)
@section('keywords', $config['site_keywords'])
@section('description', $config['site_description'])
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/prismjs@1/themes/prism-okaidia.min.css,npm/prismjs@1/plugins/toolbar/prism-toolbar.min.css,npm/prismjs@1/plugins/previewers/prism-previewers.min.css,npm/prismjs@1/plugins/command-line/prism-command-line.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/social-share.js@1/dist/css/share.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.css">
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
                        <div class="content article-content" style="word-wrap:break-word;">
                            {!! $page->feed->html !!}
                        </div>
                    </div>
                </div>
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
            let article_pre = $(".article-content pre");
            article_pre.each(function(){
                let class_val = $(this).attr('class');
                if (!class_val) {
                    let lan_class = 'language-code';
                    let pre_content = '<code class="' + lan_class + '">'+$(this).html()+'</code>';
                    $(this).html(pre_content);
                }
            });
            let article_img = $(".article-content  img");
            article_img.addClass("img-responsive");
            // 判断父类是否是a标签 是添加data属性 否添加a标签
            if (article_img.parent().is("a")) {
                article_img.parent().attr("data-fancybox","article-content");
            }
            $(".article-content  table").addClass("table table-hover table-bordered");
            $("[data-fancybox]").fancybox();
        });
    </script>
@stop
