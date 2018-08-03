@extends('layouts.backend')
@section('title','控制台 - 图床管理')
@section('css')
    {!! datatables_css() !!}
    {!! fancybox_css() !!}
    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/css/fileinput.min.css" rel="stylesheet">

@stop
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
                                        <td>{{ transform_size($item['size']) }}</td>
                                        <td>{{ transform_time($item['timestamp']) }}</td>
                                        <td>{{ $item['url'] }}</td>
                                        <td><a href="{{ $item['delete'] }}" target="_blank" class="delete-item"><span class="text-red">删除链接</span></a></td>
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
    {!! datatables_js() !!}
    {!! fancybox_js() !!}
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/js/locales/zh.min.js"></script>
    <script>
        $(function () {
            $('#image-list').DataTable({
                'language': {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            });
            $("[data-fancybox]").fancybox();
            $("#clear-list").on("click",function(){
                swal({
                    title: '确定清空吗?',
                    text: "你将清空上传历史列表!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '确定',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.value) {
                        $.get("https://sm.ms/api/clear",{},
                            function(data){
                                console.log(data);
                                swal('已清空！','请刷新列表','success');location.reload();
                            },'json');
                    }else if (
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons('已取消！',':)','error')
                    }
                } );
            } );
        });
        $("#smfile").fileinput({
            language: 'zh',
            uploadUrl: '{{ route("image_upload") }}',
            allowedFileExtensions: ["jpeg", "jpg", "png", "gif", "bmp"],
            overwriteInitial: false,
            maxFileSize: 5120,
            maxFilesNum: 10,
            maxFileCount: 10,
        });
        $("#smfile").on("fileuploaded", function (event, data, previewId, index) {
            var form = data.form,
                files = data.files,
                extra = data.extra,
                response = data.response,
                reader = data.reader;
            if (response.code == "success") {
                if ($("showurl").css("display")) {
                    $("#urlcode").append(response.data.url + "\n");
                    $("#htmlcode").append("&lt;img src=\"" + response.data.url + "\" alt=\"" + files[index].name + "\" title=\"" + files[index].name + "\" /&gt;" + "\n");
                    $("#bbcode").append("[img]" + response.data.url + "[/img]" + "\n");
                    $("#markdown").append("![" + files[index].name + "](" + response.data.url + ")" + "\n");
                    $("#markdownlinks").append("[![" + files[index].name + "](" + response.data.url + ")]" + "(" + response.data.url + ")" + "\n");
                    $("#deletecode").append(response.data.delete + "\n");

                } else if (response.data.url) {
                    $("#showurl").show();
                    $("#urlcode").append(response.data.url + "\n");
                    $("#htmlcode").append("&lt;img src=\"" + response.data.url + "\" alt=\"" + files[index].name + "\" title=\"" + files[index].name + "\" /&gt;" + "\n");
                    $("#bbcode").append("[img]" + response.data.url + "[/img]" + "\n");
                    $("#markdown").append("![" + files[index].name + "](" + response.data.url + ")" + "\n");
                    $("#markdownlinks").append("[![" + files[index].name + "](" + response.data.url + ")]" + "(" + response.data.url + ")" + "\n");
                    $("#deletecode").append(response.data.delete + "\n");
                }
            }
        });

    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
@stop
