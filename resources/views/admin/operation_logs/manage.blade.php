@extends('layouts.admin')
@section('title','日志管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    {!! datatables_css() !!}
    <style>
        .delOperationLogs :hover {
            color: #000;
        }
    </style>
    <script>
        var manageOperationLogsUrl = "{{route('operation_logs_manage')}}"
        var destroyOperationLogsUrl = "{{route('operation_logs_destroy')}}"

    </script>
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>日志管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>日志管理</strong>
            </li>
        </ol>
    </div>

@stop
@section('content')
    <table class="table operation_logsTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>操作者</th>
            <th>行为</th>
            <th>IP</th>
            <th>地址</th>
            <th>UA</th>
            <th>时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($operation_logss as $operation_logs)
            <tr>
                <td>
                    <input type="checkbox" value="{{$operation_logs->id}}" name="opid">
                </td>
                <td>{{$operation_logs->id}}</td>
                <td>{{$operation_logs->operater}}</td>
                <td>{{$operation_logs->operation}}</td>
                <td>{{$operation_logs->ip}}</td>
                <td>{{$operation_logs->address}}</td>
                <td>{{$operation_logs->device/$operation_logs->browser/$operation_logs->platform/$operation_logs->device_type/$operation_logs->language}}</td>
                <td>{{date('Y-m-d H:i:s',$operation_logs->operation_time)}}</td>
                <td>
                    <a class="text-danger delOperationLogs">
                        <i class="fa fa-trash"></i>删除
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>id</th>
            <th>操作者</th>
            <th>行为</th>
            <th>IP</th>
            <th>地址</th>
            <th>UA</th>
            <th>时间</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('opid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('opid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('opid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedOperationLogs">删除选定</a>
    <form id="deleteForm" style="display: none;" action="{{route('operation_logs_destroy')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="opid" id="deleteId">
    </form>
@stop
@section('js')
    {!! datatables_js() !!}
    {!! icheck_js() !!}
    {!! validate_js() !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".operation_logsTable").dataTable({
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
