@extends('layouts.backend')
@section('title','控制台 - 订阅管理')
@section('css')
    {!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>订阅管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">其他模块</a></li>
                <li class="active">订阅管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部订阅</h3>
                            <span>共 {{ $subscribes->total() }}条</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>id</th>
                                    <th>邮箱</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($subscribes as $subscribe)
                                    <tr>
                                        <td><label><input type="checkbox" value="{{$subscribe->id}}" name="sid" class="i-checks"></label></td>
                                        <td>{{$subscribe->id}}</td>
                                        <td>{{$subscribe->email}}</td>
                                        <td>{{ transform_time($subscribe->created_at) }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-red delSubscribes">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('subscribe_destroy')}}" method="post">
                                @csrf
                                <input type="hidden" name="sid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('sid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('sid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('sid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedSubscribes">删除选定</a>
                            </div>
                            {{ $subscribes->links('vendor.pagination.adminlte') }}
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
