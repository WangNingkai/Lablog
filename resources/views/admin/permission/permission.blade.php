@extends('layouts.backend')
@section('title','控制台 - 权限管理')
@section('css')
    {!! icheck_css() !!}
    <script>var editPermissionUrl = "{{route('permission_edit')}}"</script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>权限管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">权限管理</a></li>
                <li class="active">权限管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部权限</h3>
                            <span>共 {{ $permissions->total() }}个</span>
                            <form action="{{ route('permission_search') }}" method="get" style="display: inline-flex" class="pull-right">
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
                                    <th>权限</th>
                                    <th>路由</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td><input type="checkbox" value="{{$permission->id}}" name="pid" class="i-checks"></td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->route }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-green editPermission">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class="text-red delPermission">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{ route('permission_destroy') }}" method="post">
                                @csrf
                                <input type="hidden" name="pid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('pid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('pid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('pid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedPermission">删除选定</a>
                            </div>
                            @if(request()->has('keyword'))
                                {{ $permissions->appends(['keyword' => request()->input('keyword')])->links('vendor.pagination.adminlte') }}
                            @else
                                {{ $permissions->links('vendor.pagination.adminlte') }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @include('errors.validator')
                    <form role="form"  method="POST" action="{{ route('permission_update') }}" id="editPermissionForm" style="display: none">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑权限</h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="id" id="editId">
                                <div class="form-group {{$errors->has('edit_name')?'has-error':''}}">
                                    <label for="name">权限名：</label>
                                    <input type="text" class="form-control" name="edit_name" id="editName" placeholder="请输入权限名"  value="{{ old('edit_name')?old('edit_name'):'' }}">
                                    @if ($errors->has('edit_name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('edit_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('edit_route')?'has-error':''}}">
                                    <label for="flag">路由：</label>
                                    <input type="text" class="form-control" name="edit_route" id="editRoute" placeholder="请输入路由名称"  value="{{ old('edit_route')?old('edit_route'):'' }}">
                                    @if ($errors->has('edit_route'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('edit_route') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                    <form role="form"  method="POST" action="{{ route('permission_store') }}" id="createPermissionForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建权限</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">权限名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入权限名"  value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('route')?'has-error':''}}">
                                    <label for="flag">路由：</label>
                                    <input type="text" class="form-control" name="route" id="route" placeholder="请输入路由名称"  value="{{old('route')}}">
                                    @if ($errors->has('route'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('route') }}</strong></span>
                                    @endif
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
