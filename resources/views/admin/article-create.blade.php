@extends('layouts.backend')
@section('title','控制台 - 新文章')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inscrybmde@1/dist/inscrybmde.min.css">
    <link rel="stylesheet" href="{{ asset('css/markdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/editor.custom.css') }}">
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>新文章<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('article_manage') }}">文章管理</a></li>
                <li class="active">新文章</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form"  method="POST" action="{{route('article_store')}}" id="createArticleForm">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-success btn-flat" id="article_submit"><i class="fa fa-check"></i>&nbsp;发布</button>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('category_manage') }}" class="btn btn-primary btn-flat"><i class="fa fa-bars"></i>&nbsp;新建栏目</a>
                                    <a href="{{ route('tag_manage') }}" class="btn btn-primary btn-flat"><i class="fa fa-tag"></i>&nbsp;新建标签</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新文章</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('title')?'has-error':''}}">
                                    <label for="title">标题：</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="请输入标题"  value="{{old('title')}}">
                                    @if ($errors->has('title'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('category_id')?'has-error':''}}">
                                    <label for="category_id">栏目：</label>
                                    <select class="form-control {{$errors->has('category_id')?'has-error':''}}" name="category_id" id="category_id">
                                        <option value="">请选择栏目</option>
                                        {!! $category !!}
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('category_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('tag_ids')?'has-error':''}}">
                                    <label for="tag_ids">标签：</label>
                                    <div class="checkbox">
                                        @foreach( $tag as $tag_v)
                                            <label><input type="checkbox" class="i-checks" value="{{$tag_v->id}}" name="tag_ids[]" @if(in_array($tag_v->id, old('tag_ids', []))) checked="checked" @endif>&nbsp;{{$tag_v->name}}</label>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('tag_ids'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('tag_ids') }}</strong></span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('author')?'has-error':''}}">
                                    <label for="author">作者：</label>
                                    <input type="text" class="form-control" name="author" id="author" placeholder="在此输入作者"  value="{{old('author')?old('author'):\App\Helpers\Extensions\UserExt::getAttribute('name')}}">
                                    @if ($errors->has('author'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('author') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('keywords')?'has-error':''}}">
                                    <label for="keywords">关键词：</label>
                                    <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键词" value="{{old('keywords')}}">
                                    @if ($errors->has('keywords'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('keywords') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('description')?'has-error':''}}">
                                    <label for="description">描述：</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="请输入描述" value="{{old('description')}}">
                                    @if ($errors->has('description'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('description') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>发布：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Article::PUBLISHED }}"
                                                   @if(old( 'status', \App\Models\Article::PUBLISHED)==\App\Models\Article::PUBLISHED ) checked="checked" @endif> &nbsp;是
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Article::UNPUBLISHED }}"
                                                   @if(old( 'status', \App\Models\Article::UNPUBLISHED)==\App\Models\Article::UNPUBLISHED ) checked="checked" @endif> &nbsp;否
                                        </label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('status') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('allow_comment')?'has-error':''}}">
                                    <label>是否允许评论：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="allow_comment" value="{{ \App\Models\Article::ALLOW_COMMENT }}"
                                                   @if(old( 'allow_comment', \App\Models\Article::ALLOW_COMMENT)==\App\Models\Article::ALLOW_COMMENT ) checked="checked" @endif> &nbsp;是
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="allow_comment" value="{{ \App\Models\Article::FORBID_COMMENT }}"
                                                   @if(old( 'allow_comment', \App\Models\Article::FORBID_COMMENT)==\App\Models\Article::FORBID_COMMENT ) checked="checked" @endif> &nbsp;否
                                        </label>
                                    </div>
                                    @if ($errors->has('allow_comment'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('allow_comment') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">内容</h3>
                            </div>
                            <div class="box-body">
                                <div class=" form-group {{$errors->has('content')?'has-error':''}}">
                                    @if ($errors->has('content'))
                                        <span class="help-block"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('content') }}</strong></span>
                                    @endif
                                    <textarea name="content" id="mde" style="display:none;">{{old('content')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/inscrybmde@1/dist/inscrybmde.min.js"></script>
    <script>
        $(function () {
            $('pre code').each(function (i, block) {
                hljs.highlightBlock(block);
            });
            var mdeditor = new InscrybMDE({
                autofocus: true,
                autosave: {
                    enabled: true,
                    uniqueId: "newArticleContent",
                    delay: 1000,
                },
                blockStyles: {
                    bold: "__",
                    italic: "_"
                },
                element: $("#mde")[0],
                forceSync: true,
                indentWithTabs: false,
                insertTexts: {
                    horizontalRule: ["", "\n\n-----\n\n"],
                    image: ["![](http://", ")"],
                    link: ["[", "](http://)"],
                    table: ["",
                        "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text | Text | Text |\n\n"
                    ],
                },
                minHeight: "480px",
                parsingConfig: {
                    allowAtxHeaderWithoutSpace: true,
                    strikethrough: true,
                    underscoresBreakWords: true,
                },
                placeholder: "在此输入内容...",
                renderingConfig: {
                    singleLineBreaks: true,
                    codeSyntaxHighlighting: false,
                },
                spellChecker: false,
                status: ["autosave", "lines", "words", "cursor"],
                styleSelectedText: true,
                syncSideBySidePreviewScroll: true,
                tabSize: 4,
                toolbar: [
                    "bold", "italic", "strikethrough", "heading", "|", "quote", "code", "table",
                    "horizontal-rule", "unordered-list", "ordered-list", "|",
                    "link", "image", "|", "side-by-side", 'fullscreen', "|",
                    {
                        name: "guide",
                        action: function customFunction(editor) {
                            var win = window.open(
                                'https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md',
                                '_blank');
                            if (win) {
                                win.focus();
                            } else {
                                alert('Please allow popups for this website');
                            }
                        },
                        className: "fa fa-info-circle",
                        title: "Markdown 语法！",
                    },
                    {
                        name: "publish",
                        action: function customFunction(editor) {
                            $('#article_submit').click();
                            editor.clearAutosavedValue();
                        },
                        className: "fa fa-paper-plane",
                        title: "提交",
                    }
                ],
                toolbarTips: true,
            });
            mdeditor.codemirror.on('optionChange', (item) => {
                let fullscreen = item.getOption('fullScreen');
                if (fullscreen)
                    $(".editor-toolbar,.fullscreen,.CodeMirror-fullscreen").css('z-index','9998');
            });
        });
    </script>
@stop
