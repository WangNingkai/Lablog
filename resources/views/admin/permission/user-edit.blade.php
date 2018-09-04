@extends('layouts.backend')
@section('title','控制台 - 用户详情')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>用户详情<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('user_manage') }}">用户管理</a></li>
                <li class="active">用户详情</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form role="form"  method="POST" action="{{ route('user_update',$user->id) }}" id="editUserForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">用户详情</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('roles')?'has-error':''}}">
                                    <label for="roles">选择角色</label>
                                    <select class="form-control select2" id="roles" multiple="multiple" data-placeholder="选择角色"
                                            name="roles[]" style="width: 100%;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" @if(!is_null(old('roles')) && in_array($role->name,old('roles',[]))) selected @elseif($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('roles') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">用户名：</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name')?old('name'):$user->name }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                    <label for="email">邮箱：</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email')?old('email'):$user->email }}">
                                    <span class="help-block text-red">用于找回密码，请谨慎填写。</span>
                                    @if ($errors->has('email'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                                @if($user->id == \App\Models\User::SUPERUSER)
                                    <input type="hidden" name="status" value="{{ \App\Models\User::ACTIVE }}">
                                @else
                                    <div class="form-group">
                                    <label>用户状态：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\User::ACTIVE }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\User::ACTIVE) checked="checked" @elseif($user->status == \App\Models\User::ACTIVE ) checked="checked"  @endif> &nbsp; 正常
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\User::FORBID }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\User::FORBID) checked="checked" @elseif($user->status == \App\Models\User::FORBID ) checked="checked"  @endif> &nbsp; 禁用
                                        </label>
                                    </div>
                                </div>
                                @endif
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
