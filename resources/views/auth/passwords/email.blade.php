@extends('layouts.login-register')
@section('title','LABLOG - 通过邮箱重置密码')
@section('name','login')
@section('content')
    <div class="login-box-body">
        <p class="login-box-msg">重置密码</p>
        @if (session('status'))
            <div class="callout callout-success">
                <p>{{ session('status') }}</p>
            </div>
        @endif
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="form-group {{$errors->has('email')?'has-error':'has-feedback'}}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                       placeholder="邮箱" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-4"></div>
                <div class="col-xs-8">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">发送找回密码链接</button>
                </div>
            </div>
        </form>
    </div>
@endsection
