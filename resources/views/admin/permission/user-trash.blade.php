@extends('layouts.backend')
@section('title','控制台 - 用户小黑屋')
@section('css')
    {!! icheck_css() !!}

@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>用户小黑屋<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="active">用户小黑屋</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部删除用户</h3>
                            <span>共 {{ $users->total() }}个</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>角色</th>
                                    <th>邮箱</th>
                                    <th>用户状态</th>
                                    <th>删除时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td><input type="checkbox" value="{{$user->id}}" name="uid" class="i-checks"></td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{!! $user->all_roles_tag !!}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{!! $user->status_tag !!}</td>
                                        <td>{{ $user->deleted_at }}</td>
                                        <td>
                                            <a class="text-green restoreUser"><i class="fa fa-recycle"></i></a>&nbsp;&nbsp;
                                            <a class="text-red destroyUser"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="restoreForm" style="display: none;" method="POST" action="{{route('user_restore')}}">
                                @csrf
                                <input type="hidden" name="uid" id="restoreId">
                            </form>
                            <form id="destroyForm" style="display: none;" method="POST" action="{{route('user_destroy')}}">
                                @csrf
                                <input type="hidden" name="uid" id="destroyId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('uid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('uid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('uid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="destroySelectedUser">彻底删除选定</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-flat" id="restoreSelectedUser">恢复选定</a>
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
