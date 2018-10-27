@extends('layouts.backend')
@section('title','控制台 - 图床管理')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/webuploader@0.1.8/dist/webuploader.min.css">
    <link rel="stylesheet" href="{{ asset('css/wu.css') }}">
    <script>
        Config = {
            'routes': {
                'upload_image': '{{ route("image_upload") }}'
            },
            '_token': '{{ csrf_token() }}',
        };
    </script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>SM.MS 图床
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">SM.MS 图床</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h1 class="box-title">SM.MS</h1>
                            <span>您可以尝试文件拖拽，使用截图工具，然后激活窗口后粘贴，或者点击添加图片按钮.</span></div>
                        <div class="box-body">
                            <div id="uploader" class="wu-example">
                                <div class="queueList">
                                    <div id="dndArea" class="placeholder">
                                        <div id="filePicker"></div>
                                        <p>或将照片拖到这里，单次最多可选10张，最大单张图片支持5M</p>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress">
                                        <span class="text">0%</span>
                                        <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker2"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>
                            <div id="showUrl" style="display: none;">
                                <ul id="navTab" class="nav nav-tabs">
                                    <li><a data-toggle="tab" href="#urlPanel">URL</a></li>
                                    <li><a data-toggle="tab" href="#htmlPanel">HTML</a></li>
                                    <li><a data-toggle="tab" href="#bbPanel">bbCode</a></li>
                                    <li><a data-toggle="tab" href="#markdownPanel">Markdown</a></li>
                                    <li><a data-toggle="tab" href="#markdownLinkPanel">Markdown with Link</a></li>
                                    <li><a data-toggle="tab" href="#deletePanel">Delete Link</a></li>
                                </ul>
                                <div id="navTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="urlPanel">
                                        <pre style="margin-top: 5px;"><code id="urlCode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="htmlPanel">
                                        <pre style="margin-top: 5px;"><code id="htmlCode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="bbPanel">
                                        <pre style="margin-top: 5px;"><code id="bbCode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="markdownPanel">
                                        <pre style="margin-top: 5px;"><code id="markdown"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="markdownLinkPanel">
                                        <pre style="margin-top: 5px;"><code id="markdownLinks"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="deletePanel">
                                        <pre style="margin-top: 5px;"><code id="deleteCode"></code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/webuploader@0.1.8/dist/webuploader.min.js"></script>
    <script src="{{ asset('js/wu.js') }}"></script>
@stop
