@extends('layouts.backend')
@section('title','控制台 - 推送管理')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inscrybmde@1/dist/inscrybmde.min.css">
    <link rel="stylesheet" href="{{ asset('css/markdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/editor.custom.css') }}">
    <script>var showPushUrl = "{{route('push_info')}}"</script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>推送管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">其他模块</a></li>
                <li class="active">推送管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部推送</h3>
                            <span>共 {{ $pushes->total() }}条</span>
                            <form action="{{ route('push_list') }}" method="get" style="display: inline-flex" class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="主题">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>主题</th>
                                    <th>状态</th>
                                    <th>推送方式</th>
                                    <th>开始时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (!blank($pushes))
                                    @foreach($pushes as $push)
                                        <tr>
                                            <td></td>
                                            <td>{{ $push->id }}</td>
                                            <td>{{ $push->subject }}</td>
                                            <td>{!! $push->status_tag !!}</td>
                                            <td>{{ $push->method_tag }}</td>
                                            <td>{{ $push->started_at }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-green showPush">
                                                    <i class="fa fa-eye"></i> 查看
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td valign="top" colspan="7">表中数据为空</td></tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $pushes->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <form role="form"  method="POST" action="{{route('push_store')}}" id="createPushForm">
                    @csrf
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">创建推送</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('target')?'has-error':''}}">
                                    <label for="roles">选择用户：</label>
                                    <select class="form-control select2" id="target" multiple="multiple" data-placeholder="选择用户"
                                            name="target[]" style="width: 100%;">
                                        <option value="1" >@全体用户</option>
                                        @foreach($subscribes as $subscribe)
                                            <option value="{{ $subscribe->email }}" @if(in_array($subscribe->email,old('target',[]))) selected @endif>{{ $subscribe->email }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('target'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('target') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('subject')?'has-error':''}}">
                                    <label for="subject">推送主题：</label>
                                    <input type="subject" class="form-control" name="subject" id="subject" placeholder="请输入主题" value="{{ old('subject')}}">
                                    @if ($errors->has('subject'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('subject') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('method')?'has-error':''}}">
                                    <label>推送方式：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="method" value="0" id="push_now" > &nbsp; 立即推送
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="method" value="1" id="push_delay"> &nbsp; 定时推送
                                        </label>
                                    </div>
                                    @if ($errors->has('method'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('method') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group" id="push_time" style="display: none">
                                    <label>推送时间：</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" readonly class="form-control date" id="datetimepicker" name="started_at">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" id="submit_btn" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">推送内容</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('content')?'has-error':''}}">
                                    @if ($errors->has('content'))
                                        <span class="help-block"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('content') }}</strong></span>
                                    @endif
                                    <textarea name="content" id="mde" style="display:none;">{{old('content')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="pushModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="show_subject"></h4>
                        </div>
                        <div class="modal-body">
                            <strong>接收邮箱: </strong><br>
                            <p id="show_target"></p>
                            <strong>接收内容：</strong><br>
                            <div class="markdown-body" id="show_content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/inscrybmde@1.11.4/dist/inscrybmde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/combine/npm/inline-attachment@2/src/inline-attachment.min.js,npm/inline-attachment@2/src/codemirror-4.inline-attachment.min.js"></script>
    <script>
        $(function () {
            var mdeditor = new InscrybMDE({
                autofocus: true,
                autosave: {
                    enabled: false,
                    uniqueId: "push_mde",
                    delay: 500,
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
                minHeight: "320px",
                parsingConfig: {
                    allowAtxHeaderWithoutSpace: true,
                    strikethrough: true,
                    underscoresBreakWords: true,
                },
                placeholder: "在此输入内容...",
                renderingConfig: {
                    singleLineBreaks: true,
                    codeSyntaxHighlighting: true,
                },
                showIcons: ["code", "table"],
                spellChecker: false,
                status: ["autosave", "lines", "words", "cursor"],
                styleSelectedText: true,
                syncSideBySidePreviewScroll: true,
                tabSize: 4,
                toolbar: [
                    "bold", "italic", "strikethrough", "heading", "|", "quote", "code", "table",
                    "horizontal-rule", "unordered-list", "ordered-list", "|",
                    "link", "image", "|", "preview"
                ],
                toolbarTips: true,
            });
            mdeditor.codemirror.setSize('auto', '480px');
            $("#submit_btn").on("click",function(){
                mdeditor.clearAutosavedValue();
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
