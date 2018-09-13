@extends('layouts.backend')
@section('title','控制台 - 用户管理')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>用户管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">权限管理</a></li>
                <li class="active">用户管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            <a href="{{ route('user_create') }}" class="btn btn-success btn-flat" ><i class="fa fa-user-plus"></i>&nbsp;添加用户</a>&nbsp;&nbsp;
                            <a href="{{ route('user_trash') }}" class="btn btn-danger btn-flat" ><i class="fa fa-user"></i>&nbsp;小黑屋</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部用户</h3>
                            <span>共 {{ $users->total() }}个</span>
                            <form action="{{ route('user_search') }}" method="get" style="display: inline-flex" class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="搜索">

                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
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
                                        <th>ID</th>
                                        <th>用户名</th>
                                        <th>角色</th>
                                        <th>邮箱</th>
                                        <th>用户状态</th>
                                        <th>最后登录</th>
                                        <th>添加时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!blank($users))
                                    @foreach($users as $user)
                                    <tr>
                                        <td><input type="checkbox" value="{{$user->id}}" name="uid" class="i-checks"></td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{!! $user->all_roles_tag !!}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{!! $user->status_tag !!}</td>
                                        <td>{{ $user->last_login_at }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a href="{{ route('user_edit',$user->id) }}" class="text-green">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class="text-red delUser">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                    @else
                                    <tr><td valign="top" colspan="8">表中数据为空</td></tr>
                                @endif
                                </tbody>
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{ route('user_delete') }}" method="post">
                                @csrf
                                <input type="hidden" name="uid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('uid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('uid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('uid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedUser">删除选定</a>
                            </div>
                            @if(request()->has('keyword'))
                                {{ $users->appends(['keyword' => request()->input('keyword')])->links('vendor.pagination.adminlte') }}
                            @else
                                {{ $users->links('vendor.pagination.adminlte') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
