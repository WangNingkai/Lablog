@extends('layouts.admin')
@section('title','个人资料')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>个人资料</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>个人资料</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>基本信息</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" action="{{route('profile_update')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" placeholder="请输入您的用户名"
                               value="{{old('name')?old('name'):$admin->name}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" name="email" placeholder="请输入您的邮箱"
                               value="{{old('email')?old('email'):$admin->email}}">
                        <span class="help-block m-b-none text-danger">用于找回密码，请谨慎填写。</span>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('email')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">更新</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>密码修改</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" method="POST" action="{{route('password_update')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">原密码</label>
                    <div class="col-sm-5">
                        <input type="password" name="old_password" class="form-control" placeholder="请输入原密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('old_password')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" id="password" class="form-control" placeholder="请输入新密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('password')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-5">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="请再次输入新密码">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('password_confirmation')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop @section('js')
    {!! icheck_js() !!}
    {!! validate_js() !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });

    </script>
@stop
