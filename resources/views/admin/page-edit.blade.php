@extends('layouts.backend')
@section('title','控制台 - 编辑单页')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inscrybmde@1/dist/inscrybmde.min.css">
    <link rel="stylesheet" href="{{ asset('css/editor.custom.css') }}">
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>编辑单页<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('page_manage') }}">单页管理</a></li>
                <li class="active">编辑单页</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form"  method="POST" action="{{ route('page_update',$page->id) }}" id="updatePageForm">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-success btn-flat" id="submit_btn"><i class="fa fa-check"></i>&nbsp;保存</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑单页</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('title')?'has-error':''}}">
                                    <label for="title">标题：</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="请输入标题"  value="{{ old('title')?old('title'):$page->title }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('author')?'has-error':''}}">
                                    <label for="author">作者：</label>
                                    <input type="text" class="form-control" name="author" id="author" placeholder="在此输入作者"  value="{{old('author') ? old('author') : $page->author}}">
                                    @if ($errors->has('author'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('author') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>发布：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Page::STATUS_DISPLAY }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Page::STATUS_DISPLAY) checked="checked" @elseif($page->status == \App\Models\Page::STATUS_DISPLAY ) checked="checked"  @endif> &nbsp; 是
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Page::STATUS_HIDE }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Page::STATUS_HIDE) checked="checked" @elseif($page->status == \App\Models\Page::STATUS_HIDE ) checked="checked"  @endif> &nbsp; 否
                                        </label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('status') }}</strong></span>
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
                                    <textarea name="content" id="mde" style="display:none;">{{ old('content') ? old('content') : $page->feed->content }}</textarea>
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
    <script src="https://cdn.jsdelivr.net/combine/npm/inline-attachment@2/src/inline-attachment.min.js,npm/inline-attachment@2/src/codemirror-4.inline-attachment.min.js"></script>
    <script>
        $(function () {
            var mdeditor = new InscrybMDE({
                autoDownloadFontAwesome:false,
                autofocus: true,
                autosave: {
                    enabled: true,
                    uniqueId: "editPageContent" + "{{ $page->id }}",
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
                            $('#submit_btn').click();
                            editor.clearAutosavedValue();
                        },
                        className: "fa fa-paper-plane",
                        title: "提交",
                    }
                ],
                toolbarTips: true,
            });
            mdeditor.codemirror.setSize('auto', '640px');
            mdeditor.codemirror.on('optionChange', (item) => {
                let fullscreen = item.getOption('fullScreen');
                if (fullscreen)
                    $(".editor-toolbar,.fullscreen,.CodeMirror-fullscreen").css('z-index','9998');
            });
            inlineAttachment.editors.codemirror4.attach(mdeditor.codemirror, {
                uploadUrl: '{{ route('article_image_upload') }}',
                uploadFieldName: 'mde-image-file',
                progressText: '![正在上传文件...]()',
                urlText: "\n ![未命名]({filename}) \n\n",
                extraParams: {
                    "_token": '{{ csrf_token() }}'
                },
                onFileUploadResponse: function(xhr) {
                    var result = JSON.parse(xhr.responseText),
                        filename = result[this.settings.jsonFieldName];

                    if (result && filename) {
                        var newValue;
                        if (typeof this.settings.urlText === 'function') {
                            newValue = this.settings.urlText.call(this, filename, result);
                        } else {
                            newValue = this.settings.urlText.replace(this.filenameTag, filename);
                        }
                        var text = this.editor.getValue().replace(this.lastValue, newValue);
                        this.editor.setValue(text);
                        this.settings.onFileUploaded.call(this, filename);
                    }
                    return false;
                }
            });
        });
    </script>
@stop
