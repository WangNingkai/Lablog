@extends('layouts.login-register')
@section('title','LABLOG - 注册')
@section('name','register')
@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">注册</p>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group {{$errors->has('name')?'has-error':'has-feedback'}}">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="姓名" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group {{$errors->has('email')?'has-error':'has-feedback'}}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="邮箱"
                       required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            <div class="form-group {{$errors->has('password')?'has-error':'has-feedback'}}">
                <input id="password" type="password" class="form-control" name="password" placeholder="密码" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="再次输入密码" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
                </div>
            </div>
        </form>
        <a href="{{route('login')}}" class="text-center">我有会员帐号</a>
    </div>
@endsection
