@extends('layouts.login-register')
@section('title','LABLOG - 登陆')
@section('name','login')
@section('content')
    <div class="login-box-body">
        <p class="login-box-msg">帐户登录</p>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group {{$errors->has('email')?'has-error':'has-feedback'}}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                       placeholder="邮箱" required autofocus>
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
            <div class="form-group">
                <img src="{{ captcha_src('inverse') }}" style="cursor: pointer"
                     onclick="this.src='{{ captcha_src('inverse') }}'+Math.random()">
            </div>
            <div class="form-group {{$errors->has('captcha')?'has-error':'has-feedback'}}">
                <input id="captcha" type="text" class="form-control" name="captcha" placeholder="验证码" required>
                @if ($errors->has('captcha'))
                    <span class="help-block"><strong>{{ $errors->first('captcha') }}</strong></span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
            </div>
        </form>
        <div class="social-auth-links text-center">
            <p>- 或者 -</p>
            <a href="{{ route('oauth.redirect','qq') }}" class="btn btn-block btn-social  btn-flat bg-blue"><i
                    class="fa fa-qq"></i> 使用
                QQ</a>
            <a href="{{ route('oauth.redirect','weibo') }}" class="btn btn-block btn-social  btn-flat bg-red"><i
                    class="fa fa-weibo"></i> 使用
                微博</a>
            <a href="{{ route('oauth.redirect','github') }}" class="btn btn-block btn-social  btn-flat bg-black"><i
                    class="fa fa-github"></i> 使用
                GitHub</a>
        </div>
        <a href="{{ route('password.request') }}">忘记密码？</a><br>
    </div>
@endsection
