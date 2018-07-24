@extends('layouts.backend')
@section('title','控制台 - 操作日志')
@section('css')
{!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>操作日志<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">操作日志</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部日志</h3>
                            <span>共 {{ $operation_logs->total() }}条</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>id</th>
                                    <th>操作者</th>
                                    <th>行为</th>
                                    <th>IP</th>
                                    <th>地址</th>
                                    <th>UA</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($operation_logs as $operation_log)
                                <tr>
                                    <td><input type="checkbox" value="{{$operation_log->id}}" name="opid" class="i-checks"></td>
                                    <td>{{$operation_log->id}}</td>
                                    <td>{{$operation_log->operater}}</td>
                                    <td>{{$operation_log->operation}}</td>
                                    <td>{{$operation_log->ip}}</td>
                                    <td>{{$operation_log->address}}</td>
                                    <td>{{$operation_log->device."-".$operation_log->browser."-".$operation_log->platform ."-".$operation_log->device_type."-".$operation_log->language}}</td>
                                    <td>{{date('Y-m-d H:i:s',$operation_log->operation_time)}}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="text-red delOperationLogs">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('operation_logs_destroy')}}" method="post">
                                @csrf
                                <input type="hidden" name="opid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('opid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('opid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="delSelectedOperationLogs('opid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedOperationLogs">删除选定</a>
                            </div>
                             {{ $operation_logs->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
{!! icheck_js() !!}
<script>
    $(function () {
        $(".i-checks").iCheck({
            checkboxClass: "icheckbox_square-blue",
            radioClass: "iradio_square-blue",
        });
    });
</script>
<script src="{{ asset('js/admin.js') }}"></script>
@stop
