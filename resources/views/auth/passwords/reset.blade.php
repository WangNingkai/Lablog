@extends('layouts.login-register')
@section('title','LABLOG - 密码重置')
@section('name','register')
@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">密码重置</p>
        <form action="{{ route('password.request') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group {{$errors->has('email')?'has-error':'has-feedback'}}">
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="邮箱"
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
            <div class="form-group {{$errors->has('password_confirmation')?'has-error':'has-feedback'}}">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="再次输入密码" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection
