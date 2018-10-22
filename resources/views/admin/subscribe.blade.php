@extends('layouts.backend')
@section('title','控制台 - 订阅管理')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>订阅管理
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">其他模块</a></li>
                <li class="active">订阅管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="pull-left">
                                <a class="btn btn-success btn-flat" href="{{ route('push_list') }}"><i
                                        class="fa fa-plus-circle"></i>&nbsp;推送订阅消息</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部订阅</h3>
                            <span>共 {{ $subscribes->total() }}条</span>
                            <form action="{{ route('subscribe_manage') }}" method="get" style="display: inline-flex"
                                  class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="邮箱">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i
                                                    class="fa fa-search"></i></button>
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
                                    <th>id</th>
                                    <th>邮箱</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!blank($subscribes))
                                    @foreach($subscribes as $subscribe)
                                        <tr>
                                            <td><label><input type="checkbox" value="{{$subscribe->id}}" name="sid"
                                                              class="i-checks"></label></td>
                                            <td>{{$subscribe->id}}</td>
                                            <td>{{$subscribe->email}}</td>
                                            <td>{{ \App\Helpers\Extensions\Tool::transformTime($subscribe->created_at) }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-red delSubscribes">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td valign="top" colspan="5">表中数据为空</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('subscribe_destroy')}}"
                                  method="post">
                                @csrf
                                <input type="hidden" name="sid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectAll('sid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectEmpty('sid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectReverse('sid')">反选</a>
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
