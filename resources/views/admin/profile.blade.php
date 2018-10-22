@extends('layouts.backend')
@section('title','控制台 - 个人信息')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>个人信息
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li class="active">个人信息</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <form role="form" method="POST" action="{{ route('profile_update') }}" id="editProfileForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">基本设置</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label>上传头像：</label>
                                    <div class="avatar-view">
                                        <a data-toggle="modal" href='#avatar-modal'>
                                            <img class="img-responsive img-circle" src="{{ $admin->avatar }}"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">用户名：</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{old('name')?old('name'):$admin->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i
                                                    class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('email')?'has-error':''}}">
                                    <label for="email">邮箱：</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{old('email')?old('email'):$admin->email}}">
                                    <span class="help-block text-red">用于找回密码，请谨慎填写。</span>
                                    @if ($errors->has('email'))
                                        <span class="help-block "><strong><i
                                                    class="fa fa-times-circle-o"></i>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form role="form" method="POST" action="{{route('password_update')}}" id="changePassForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">密码修改</h3>
                            </div>
                            <div class="box-body">

                                <div class="form-group {{$errors->has('old_password')?'has-error':''}}">
                                    <label for="old_password">原密码：</label>
                                    <input type="password" class="form-control" name="old_password" id="old_password"
                                           placeholder="请输入原密码">
                                    @if ($errors->has('old_password'))
                                        <span class="help-block "><strong><i
                                                    class="fa fa-times-circle-o"></i>{{ $errors->first('old_password') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('password')?'has-error':''}}">
                                    <label for="password">新密码：</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="请输入新密码">
                                    @if ($errors->has('password'))
                                        <span class="help-block "><strong><i
                                                    class="fa fa-times-circle-o"></i>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('password_confirmation')?'has-error':''}}">
                                    <label for="password_confirmation">确认密码：</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                           id="password_confirmation" placeholder="请再次输入新密码">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block "><strong><i
                                                    class="fa fa-times-circle-o"></i>{{ $errors->first('password_confirmation') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">第三方登录绑定</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">QQ：</div>
                                <div class="col-md-8">
                                    @if(blank($admin->bindQQ))<a href="{{ route('oauth.redirect','qq') }}"
                                                                 class="btn btn-flat bg-gray">点击绑定</a>
                                    @else  <a href="javascript:void(0)" class="btn btn-flat bg-gray">已绑定
                                        ({{ $admin->qqName }})</a>
                                    <a href="javascript:void(0)" class="btn btn-flat bg-red unbind-btn" data-type="qq">解除</a>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div class="col-md-4">微博：</div>
                                <div class="col-md-8">
                                    @if(blank($admin->bindWeibo))<a href="{{ route('oauth.redirect','weibo') }}"
                                                                    class="btn btn-flat bg-gray">点击绑定</a>
                                    @else  <a href="javascript:void(0)" class="btn btn-flat bg-gray">已绑定
                                        ({{ $admin->weiboName }})</a>
                                    <a href="javascript:void(0)" class="btn btn-flat bg-red unbind-btn"
                                       data-type="weibo">解除</a>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="row">
                                <div class="col-md-4">GitHub：</div>
                                <div class="col-md-8">
                                    @if(blank($admin->bindGithub))<a href="{{ route('oauth.redirect','github') }}"
                                                                     class="btn btn-flat bg-gray">点击绑定</a>
                                    @else  <a href="javascript:void(0)" class="btn btn-flat bg-gray">已绑定
                                        ({{ $admin->githubName }})</a>
                                    <a href="javascript:void(0)" class="btn btn-flat bg-red unbind-btn"
                                       data-type="github">解除</a>
                                    @endif
                                </div>
                            </div>
                            <form id="unbindForm" style="display: none;" action="{{ route('unbind_third_login') }}"
                                  method="post">
                                @csrf
                                <input type="hidden" name="type" id="bindType">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="avatar-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">上传头像</h4>
                    </div>
                    <form action="{{ route('avatar_upload') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="file" name="avatar" class="dropify" data-max-height="200"
                                   data-allowed-file-extensions="png jpg jpeg" data-max-file-size="2M"/>
                            <span class="help-block">头像支持png、jpg、jepg 格式小于2M的图片.为保证头像质量请上传等比例的图片。并保证宽度小于200像素</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-flat">上传</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
