@extends('layouts.backend')
@section('title','控制台 - 图床管理')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>图床管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">图床管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">上传列表</h3>
                            <span>(最近一小时上传历史)</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table id="image-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>缩略图</th>
                                    <th>文件名</th>
                                    <th>保存名</th>
                                    <th>大小</th>
                                    <th>时间</th>
                                    <th>路径</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr>
                                        <td><a href="{{ $item['url'] }}" data-fancybox="image-list" data-caption="{{ $item['url'] }}">
                                                <img src="{{ $item['url'] }}" alt="{{ $item['url'] }}" width="30" height="30"/>
                                            </a></td>
                                        <td>{{ $item['filename'] }}</td>
                                        <td>{{ $item['storename'] }}</td>
                                        <td>{{ \App\Helpers\Extensions\Tool::transformSize($item['size']) }}</td>
                                        <td>{{ \App\Helpers\Extensions\Tool::transformTime($item['timestamp']) }}</td>
                                        <td>{{ $item['url'] }}</td>
                                        <td><a href="javascript:void(0)" class="delete-item" data-hash="{{ $item['hash'] }}"><span class="text-red">删除链接</span></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>缩略图</th>
                                    <th>文件名</th>
                                    <th>保存名</th>
                                    <th>大小</th>
                                    <th>时间</th>
                                    <th>路径</th>
                                    <th>操作</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" id="clear-list" class="btn btn-danger btn-flat">清空历史</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h1 class="box-title">图片上传</h1>
                            <span>每个文件最大 5 MB . 每次请求最多10个文件.</span>
                        </div>
                        <div class="box-body">

                            <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <input id="smfile" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1" data-max-file-count="10" name="smfile" accept="image/*">
                                </div>
                            </form>
                            <div id="showurl" style="display: none;">
                                <ul id="navTab" class="nav nav-tabs">
                                    <li class="active"><a href="#urlcodes" data-toggle="tab">URL</a></li>
                                    <li><a href="#htmlcodes" data-toggle="tab">HTML</a></li>
                                    <li><a href="#bbcodes" data-toggle="tab">BBCode</a></li>
                                    <li><a href="#markdowncodes" data-toggle="tab">Markdown</a></li>
                                    <li><a href="#markdowncodes2" data-toggle="tab">Markdown with Link</a></li>
                                    <li><a href="#deletepanel" data-toggle="tab">Delete Link</a></li>
                                </ul>
                                <div id="navTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="urlcodes">
                                        <pre style="margin-top: 5px;"><code id="urlcode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="htmlcodes">
                                        <pre style="margin-top: 5px;"><code id="htmlcode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="bbcodes">
                                        <pre style="margin-top: 5px;"><code id="bbcode"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="markdowncodes">
                                        <pre style="margin-top: 5px;"><code id="markdown"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="markdowncodes2">
                                        <pre style="margin-top: 5px;"><code id="markdownlinks"></code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="deletepanel">
                                        <pre style="margin-top: 5px;"><code id="deletecode"></code></pre>
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
    <script>
        $("#smfile").fileinput({
            language: 'zh',
            uploadUrl: '{{ route("image_upload") }}',
            allowedFileExtensions: ["jpeg", "jpg", "png", "gif", "bmp"],
            uploadExtraData:{"_token": "{{ csrf_token() }}"},
            overwriteInitial: false,
            maxFileSize: 5120,
            maxFilesNum: 10,
            maxFileCount: 10,
        });
    </script>
@stop
