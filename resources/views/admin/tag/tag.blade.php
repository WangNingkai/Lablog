@extends('layouts.admin') @section('title','标签管理') @section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    {!! datatables_css() !!}
    <style>
        .editTag :hover,
        .delTag :hover {
            color: #000;
        }
    </style>
    <script>
        var manageTagUrl = "{{route('tag_manage')}}"
        var editTagUrl = "{{route('tag_edit')}}"
        var destroyTagUrl = "{{route('tag_destroy')}}"

    </script>
@stop @section('page-heading')
    <div class="col-sm-4">
        <h2>标签管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>标签管理</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a data-toggle="modal" href="#addTagModal" class="btn btn-primary">添加标签</a>
            <a href="{{route('category_manage')}}" class="btn btn-primary">分类管理</a>
            <a href="{{route('article_manage')}}" class="btn btn-primary">文章管理</a>
        </div>
    </div>
@stop @section('content')
    <table class="table tagTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>标签名</th>
            <th>标识</th>
            <th>文章数</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tags as $tag)
            <tr>
                <td>
                    <input type="checkbox" value="{{$tag->id}}" name="tid">
                </td>
                <td>{{$tag->name}}</td>
                <td>{{$tag->flag}}</td>
                <td>{{$tag->article_count}}</td>
                <td>
                    <a class="text-success editTag">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>&nbsp;&nbsp;
                    <a class="text-danger delTag">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>标签名</th>
            <th>标识</th>
            <th>文章数</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('tid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('tid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('tid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedTag">删除选定</a>
    <form id="deleteForm" style="display: none;" action="{{route('tag_destroy')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="tid" id="deleteId">
    </form>
    <!-- 添加标签  -->
    <div class="modal fade" id="addTagModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" id="addTagForm" method="POST"
                      action="{{route('tag_create')}}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">添加标签</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标签名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="请输入标签名"
                                       value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标识</label>
                            <div class="col-sm-10">
                                <input type="text" name="flag" class="form-control" placeholder="请输入标签标识"
                                       value="{{ old('flag') }}">
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
    <!-- 编辑标签  -->
    <div class="modal fade" id="editTagModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" id="editTagForm" method="POST"
                      action="{{route('tag_update')}}">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">编辑标签</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标签名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="editName" placeholder="请输入标签名"
                                       value="{{ old('name')?old('name'):'' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标识</label>
                            <div class="col-sm-10">
                                <input type="text" name="flag" class="form-control" id="editFlag" placeholder="请输入标签标识"
                                       value="{{ old('flag')?old('flag'):'' }}">
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
    {!! datatables_js() !!}
    {!! icheck_js() !!}
    {!! validate_js() !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".tagTable").dataTable({
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
