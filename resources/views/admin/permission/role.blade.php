@extends('layouts.backend')
@section('title','控制台 - 角色管理')
@section('css')
    {!! icheck_css() !!}
    <script></script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>角色管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">权限管理</a></li>
                <li class="active">角色管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部角色</h3>
                            <span>共 {{ $roles->total() }}个</span>
                            <form action="{{ route('role_search') }}" method="get" style="display: inline-flex" class="pull-right">
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
                                <tr>
                                    <th>#</th>
                                    <th>角色名</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($roles as $role)
                                    <tr>
                                        <td><input type="checkbox" value="{{$role->id}}" name="rid" class="i-checks"></td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a href="{{ route('role_edit',$role->id) }}" class="text-green editRole">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class="text-red delRole">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{ route('role_destroy') }}" method="post">
                                @csrf
                                <input type="hidden" name="rid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('rid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('rid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('rid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedRole">删除选定</a>
                            </div>
                            @if(request()->has('keyword'))
                                {{ $roles->appends(['keyword' => request()->input('keyword')])->links('vendor.pagination.adminlte') }}
                            @else
                                {{ $roles->links('vendor.pagination.adminlte') }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form role="form"  method="POST" action="{{route('role_store')}}" id="createRoleForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建角色</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">角色名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入角色名称"  value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="permissions">权限：</label>
                                    <div class="checkbox">
                                        @foreach( $permissions as $permission)
                                            <label><input type="checkbox" class="i-checks" value="{{$permission->name}}" name="permissions[]" @if(in_array($permission->name, old('permissions', []))) checked="checked" @endif>&nbsp;{{$permission->name}}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
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
