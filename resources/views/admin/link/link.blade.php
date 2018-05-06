@extends('layouts.admin')
@section('title','友链管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <style>
        .editLink :hover,
        .delLink :hover {
            color: #000;
        }
    </style>
    <script>
        var manageLinkUrl = "{{route('link_manage')}}"
        var editLinkUrl = "{{route('link_edit')}}"
        var destroyLinkUrl = "{{route('link_destroy')}}"
    </script>
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>友链管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>友链管理</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a data-toggle="modal" href="#addLinkModal" class="btn btn-primary">添加友链</a>
        </div>
    </div>
@stop
@section('content')
    <table class="table linkTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>友链名</th>
            <th>地址</th>
            <th>排序权重</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($links as $link)
            <tr>
                <td>
                    <input type="checkbox" value="{{$link->id}}" name="lid">
                </td>
                <td>{{$link->name}}</td>
                <td>{{$link->url}}</td>
                <td>{{$link->sort}}</td>
                <td>
                    <a class="text-success editLink">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>&nbsp;&nbsp;
                    <a class="text-danger delLink">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>友链名</th>
            <th>地址</th>
            <th>排序权重</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('lid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('lid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('lid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedLink">删除选定</a>
    <form id="deleteForm" style="display: none;" action="{{route('link_destroy')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="lid" id="deleteId">
    </form>
    <!-- 添加友链  -->
    <div class="modal fade" id="addLinkModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" id="addLinkForm" method="POST"
                      action="{{route('link_create')}}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">添加友链</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">友链名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="请输入友链名"
                                       value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地址</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" class="form-control" placeholder="请输入友链地址"
                                       value="{{ old('url') }}">
                                <span class="help-block m-b-none">链接前请加上协议(如:https://xxx.com)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序权重</label>
                            <div class="col-sm-10">
                                <input type="text" name="sort" class="form-control" placeholder="请输入排序权重"
                                       value="{{ old('sort') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 编辑友链  -->
    <div class="modal fade" id="editLinkModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" id="editLinkForm" method="POST"
                      action="{{route('link_update')}}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">编辑友链</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">友链名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="editName" placeholder="请输入友链名"
                                       value="{{ old('name')?old('name'):'' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">地址</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" class="form-control" id="editUrl" placeholder="请输入友链地址"
                                       value="{{ old('url')?old('url'):'' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序权重</label>
                            <div class="col-sm-10">
                                <input type="text" name="sort" class="form-control" id="editSort" placeholder="请输入排序权重"
                                       value="{{ old('sort')?old('sort'):'' }}">
                            </div>
                        </div>
                        <input type="hidden" name="id" id="editId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop @section('js')
    <!-- <script src="{{asset('tpl/plugins/dataTables/jquery.dataTables.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/iCheck/icheck.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/jquery-validate/jquery.validate.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/jquery-validate/messages_zh.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/localization/messages_zh.min.js"></script>
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".linkTable").dataTable({
                language: {
                    url: "{{asset('tpl/plugins/dataTables/Chinese.json')}}"
                },
                "columns": [{
                    "orderable": false
                }, null, null, null, {
                    "orderable": false
                },],
            });
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });

    </script>
@stop
