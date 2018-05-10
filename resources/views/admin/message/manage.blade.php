@extends('layouts.admin')
@section('title','留言管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    {!! datatables_css() !!}
    <style>
        .showMessage :hover,
        .delMessage :hover {
            color: #000;
        }
    </style>
    <script>
        var manageMessageUrl = "{{route('message_manage')}}";
        var showMessageUrl = "{{route('message_show')}}";
        var checkMessageUrl = "{{route('message_check')}}";
        var destroyMessageUrl = "{{route('message_destroy')}}";
    </script>
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>留言管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>留言管理</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <table class="table messageTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>昵称</th>
            <th>邮箱</th>
            <th>内容</th>
            <th>时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($messages as $message)
            <tr>
                <td>
                    <input type="checkbox" value="{{$message->id}}" name="mid">
                </td>
                <td>{{$message->nickname}}</td>
                <td>{{$message->email}}</td>
                <td>{{$message->content}}</td>
                <td>{{$message->created_at}}</td>
                <td> @if($message->status==1)
                        <span class="text-success">已审核</span>
                    @else
                        <span class="text-danger">未审核</span>
                    @endif</td>
                <td>
                    <a class="text-success showMessage">
                        查看
                    </a>&nbsp;&nbsp;
                    <a class="text-danger delMessage">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>昵称</th>
            <th>邮箱</th>
            <th>内容</th>
            <th>时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('mid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('mid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('mid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedMessage">删除选定</a>
    <a href="javascript:void(0)" class="btn btn-info" id="checkSelectedMessage">审核选定</a>
    <form id="deleteForm" style="display: none;" method="POST" action="{{route('message_destroy')}}">
        {{ csrf_field() }}
        <input type="hidden" name="mid" id="deleteId">
    </form>
    <form id="checkForm" style="display: none;" method="POST" action="{{route('message_check')}}">
        {{ csrf_field() }}
        <input type="hidden" name="mid" id="checkId">
    </form>
    <!--查看留言  -->
    <div class="modal fade" id="messageModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" role="form" method="POST" action="{{route('message_reply')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="mid">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">留言审核</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                                <p class="form-control-static" id="nickname"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-10">
                                <p class="form-control-static" id="email"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-10">
                                <p class="form-control-static" id="content"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">时间</label>
                            <div class="col-sm-10">
                                <p class="form-control-static" id="created_at"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">回复</label>
                            <div class="col-sm-10">
                                <input type="text" name="reply" id="replay" class="form-control" placeholder="在此输入回复内容">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">回复</button>
                        <button type="button" class="checkMessage btn btn-primary">通过</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    {!! datatables_js() !!}
    {!! icheck_js() !!}
    {!! validate_js() !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".messageTable").dataTable({
                language: {
                    url: "{{asset('tpl/plugins/dataTables/Chinese.json')}}"
                },
                "columns": [{
                    "orderable": false
                }, null, null,null, null, null, {
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
