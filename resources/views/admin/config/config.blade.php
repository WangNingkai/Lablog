@extends('layouts.admin')
@section('title','配置管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>配置管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>配置管理</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>网站配置</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" role="form" id="configForm" method="POST"
                  action="{{ route('config_update') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站状态：</label>
                    <div class="col-sm-5">
                        <label class="radio-inline i-checks">
                            <input type="radio" name="site_status" value="1"
                                   @if($config[ 'site_status']==1) checked @endif> &nbsp; 开启
                        </label>
                        <label class="radio-inline i-checks">
                            <input type="radio" name="site_status" value="0"
                                   @if($config[ 'site_status']==0) checked @endif> &nbsp; 关闭
                        </label>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_status')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站关闭时提示文字：</label>
                    <div class="col-sm-5">
                        <textarea name="site_close_word"
                                  class="form-control">{{ $config['site_close_word'] }}</textarea>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_close_word')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站名：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_name" value="{{ $config['site_name'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站标题：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_title" value="{{ $config['site_title'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_title')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站关键词：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_keywords"
                               value="{{ $config['site_keywords'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_keywords')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站描述：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_description"
                               value="{{ $config['site_description'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_description')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站备案号：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_icp_num"
                               value="{{ $config['site_icp_num'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_icp_num')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站管理员名称：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_admin" value="{{ $config['site_admin'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_admin')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站管理邮箱地址：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_admin_mail"
                               value="{{ $config['site_admin_mail'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_admin_mail')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站管理微博地址：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_admin_weibo"
                               value="{{ $config['site_admin_weibo'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_admin_weibo')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站管理GitHub地址：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_admin_github"
                               value="{{ $config['site_admin_github'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_admin_github')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站管理个人介绍：</label>
                    <div class="col-sm-5">
                        {{--<input type="text" class="form-control" name="site_admin_info" value="{{ $config['site_admin_info'] }}">--}}
                        <textarea name="site_admin_info" class="form-control">{{ $config['site_admin_info'] }}</textarea>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_admin_info')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">站点消息：</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="site_info" value="{{ $config['site_info'] }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('site_info')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop @section('js')

    <script src="{{asset('tpl/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });
    </script>
@stop
