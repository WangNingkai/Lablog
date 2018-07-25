@extends('layouts.backend')
@section('title','控制台 - 站点设置')
@section('css')
{!! icheck_css() !!}

@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>站点设置<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">我的站点</a></li>
                <li class="active">站点设置</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form" method="POST" action="{{ route('config_update') }}">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i>&nbsp;提交</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">常规设置</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('site_name')?'has-error':''}}">
                                    <label for="site_name">站点名：</label>
                                    <input type="text" class="form-control" name="site_name" id="site_name" value="{{ $config['site_name'] }}">
                                        @if ($errors->has('site_name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_status')?'has-error':''}}">
                                    <label>网站开启状态：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="site_status" value="1"
                                                @if($config[ 'site_status']==1) checked @endif> &nbsp; 开启
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="site_status" value="0"
                                                @if($config[ 'site_status']==0) checked @endif> &nbsp; 关闭
                                        </label>
                                    </div>
                                    @if ($errors->has('site_status'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_status') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_close_word')?'has-error':''}}">
                                    <label for="site_close_word">关站提示文字：</label>
                                    <textarea class="form-control" rows="3" name="site_close_word" placeholder="输入 ..." style="resize: none;">{{ $config['site_close_word'] }}</textarea>
                                    @if ($errors->has('site_close_word'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_close_word') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_info')?'has-error':''}}">
                                    <label for="">站点通知：</label>
                                    <textarea class="form-control" rows="5" name="site_info" placeholder="输入 ..." style="resize: none;">{{ $config['site_info'] }}</textarea>
                                    @if ($errors->has('site_info'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_info') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">SEO设置</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('site_title')?'has-error':''}}">
                                    <label for="site_title">网站标题：</label>
                                    <input type="text" class="form-control" name="site_title" id="site_title" value="{{ $config['site_title'] }}">
                                        @if ($errors->has('site_title'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_title') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_keywords')?'has-error':''}}">
                                    <label for="site_keywords">网站关键词：</label>
                                    <input type="text" class="form-control" name="site_keywords" id="site_keywords" value="{{ $config['site_keywords'] }}">
                                        @if ($errors->has('site_keywords'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_keywords') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_description')?'has-error':''}}">
                                    <label for="site_description">网站描述：</label>
                                    <input type="text" class="form-control" name="site_description" id="site_description" value="{{ $config['site_description'] }}">
                                        @if ($errors->has('site_description'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_description') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">站长设置</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('site_admin')?'has-error':''}}">
                                    <label for="site_admin">站长名称：</label>
                                    <input type="text" class="form-control" name="site_admin" id="site_admin" value="{{ $config['site_admin'] }}"> @if ($errors->has('site_admin'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_admin_avatar')?'has-error':''}}">
                                    <label for="site_admin_avatar">站长头像：</label>
                                    <input type="text" class="form-control" name="site_admin_avatar" id="site_admin_avatar" value="{{ $config['site_admin_avatar'] }}"> @if ($errors->has('site_admin_avatar'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin_avatar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_admin_info')?'has-error':''}}">
                                    <label for="site_admin_info">站长个人介绍：</label>
                                    <input type="text" class="form-control" name="site_admin_info" id="site_admin_info" value="{{ $config['site_admin_info'] }}"> @if ($errors->has('site_admin_info'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin_info') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_mailto_admin')?'has-error':''}}">
                                    <label for="site_mailto_admin">站长邮箱：</label>
                                    <input type="text" class="form-control" name="site_mailto_admin" id="site_mailto_admin" value="{{ $config['site_mailto_admin'] }}"> @if ($errors->has('site_mailto_admin'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_mailto_admin') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_admin_mail')?'has-error':''}}">
                                    <label for="site_admin_mail">站长邮箱投稿地址：</label>
                                    <input type="text" class="form-control" name="site_admin_mail" id="site_admin_mail" value="{{ $config['site_admin_mail'] }}"> @if ($errors->has('site_admin_mail'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin_mail') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_admin_weibo')?'has-error':''}}">
                                    <label for="site_admin_weibo">微博地址：</label>
                                    <input type="text" class="form-control" name="site_admin_weibo" id="site_admin_weibo" value="{{ $config['site_admin_weibo'] }}"> @if ($errors->has('site_admin_weibo'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin_weibo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_admin_github')?'has-error':''}}">
                                    <label for="site_admin_github">GitHub地址：</label>
                                    <input type="text" class="form-control" name="site_admin_github" id="site_admin_github" value="{{ $config['site_admin_github'] }}"> @if ($errors->has('site_admin_github'))
                                    <span class="help-block ">
                                        <strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_admin_github') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">备案设置</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('site_icp_num')?'has-error':''}}">
                                    <label for="site_icp_num">网站备案号：</label>
                                    <input type="text" class="form-control" name="site_icp_num" id="site_icp_num" value="{{ $config['site_icp_num'] }}">
                                        @if ($errors->has('site_icp_num'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_icp_num') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_110beian_num')?'has-error':''}}">
                                    <label for="site_110beian_num">公安网站备案号：</label>
                                    <input type="text" class="form-control" name="site_110beian_num" id="site_110beian_num" value="{{ $config['site_110beian_num'] }}">
                                        @if ($errors->has('site_110beian_num'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_110beian_num') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('site_110beian_link')?'has-error':''}}">
                                    <label for="site_110beian_link">公安网站备案链接：</label>
                                    <input type="text" class="form-control" name="site_110beian_link" id="site_110beian_link" value="{{ $config['site_110beian_link'] }}">
                                        @if ($errors->has('site_110beian_link'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_110beian_link') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
@stop
