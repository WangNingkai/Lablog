@extends('layouts.backend')
@section('title','控制台 - 站点设置')
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
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">常规设置</a></li>
                                <li><a href="#tab_2" data-toggle="tab">SEO设置</a></li>
                                <li><a href="#tab_3" data-toggle="tab">功能设置</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
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
                                <div class="tab-pane" id="tab_2">
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
                                <div class="tab-pane" id="tab_3">
                                    <div class="form-group {{$errors->has('site_allow_comment')?'has-error':''}}">
                                        <label>是否开启文章评论：</label>
                                        <div class="radio">
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_comment" value="1"
                                                       @if($config[ 'site_allow_comment']==1) checked @endif> &nbsp; 开启
                                            </label>
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_comment" value="0"
                                                       @if($config[ 'site_allow_comment']==0) checked @endif> &nbsp; 关闭
                                            </label>
                                        </div>
                                        @if ($errors->has('site_allow_comment'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_allow_comment') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group {{$errors->has('site_allow_message')?'has-error':''}}">
                                        <label>是否开启站点留言：</label>
                                        <div class="radio">
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_message" value="1"
                                                       @if($config[ 'site_allow_message']==1) checked @endif> &nbsp; 开启
                                            </label>
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_message" value="0"
                                                       @if($config[ 'site_allow_message']==0) checked @endif> &nbsp; 关闭
                                            </label>
                                        </div>
                                        @if ($errors->has('site_allow_message'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_allow_message') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group {{$errors->has('site_allow_subscribe')?'has-error':''}}">
                                        <label>是否开启站点订阅：</label>
                                        <div class="radio">
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_subscribe" value="1"
                                                       @if($config[ 'site_allow_subscribe']==1) checked @endif> &nbsp; 开启
                                            </label>
                                            <label class="i-checks">
                                                <input type="radio" name="site_allow_subscribe" value="0"
                                                       @if($config[ 'site_allow_subscribe']==0) checked @endif> &nbsp; 关闭
                                            </label>
                                        </div>
                                        @if ($errors->has('site_allow_subscribe'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('site_allow_subscribe') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group {{$errors->has('allow_reward')?'has-error':''}}">
                                        <label>是否开启文章打赏：</label>
                                        <div class="radio">
                                            <label class="i-checks">
                                                <input type="radio" name="allow_reward" value="1"
                                                       @if($config[ 'allow_reward']==1) checked @endif> &nbsp; 开启
                                            </label>
                                            <label class="i-checks">
                                                <input type="radio" name="allow_reward" value="0"
                                                       @if($config[ 'allow_reward']==0) checked @endif> &nbsp; 关闭
                                            </label>
                                        </div>
                                        @if ($errors->has('allow_reward'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('allow_reward') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group {{$errors->has('alipay')?'has-error':''}}">
                                        <label for="alipay">支付宝打赏二维码地址：</label>
                                        <input type="text" class="form-control" name="alipay" id="alipay" value="{{ $config['alipay'] }}">
                                        @if ($errors->has('alipay'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('alipay') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group {{$errors->has('wepay')?'has-error':''}}">
                                        <label for="site_title">微信打赏二维码地址：</label>
                                        <input type="text" class="form-control" name="wepay" id="wepay" value="{{ $config['wepay'] }}">
                                        @if ($errors->has('wepay'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('wepay') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_4" data-toggle="tab">站长设置</a></li>
                                <li><a href="#tab_5" data-toggle="tab">备案设置</a></li>
                                <li><a href="#tab_6" data-toggle="tab">其它设置</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_4">
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
                                <div class="tab-pane" id="tab_5">
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
                                <div class="tab-pane" id="tab_6">
                                    <div class="form-group {{$errors->has('water_mark_status')?'has-error':''}}">
                                        <label>开启图片水印：</label>
                                        <div class="radio">
                                            <label class="i-checks">
                                                <input type="radio" name="water_mark_status" value="1"
                                                       @if($config[ 'water_mark_status']==1) checked @endif> &nbsp; 开启
                                            </label>
                                            <label class="i-checks">
                                                <input type="radio" name="water_mark_status" value="0"
                                                       @if($config[ 'water_mark_status']==0) checked @endif> &nbsp; 关闭
                                            </label>
                                        </div>
                                        @if ($errors->has('water_mark_status'))
                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('water_mark_status') }}</strong></span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>上传水印(默认图片右下角)：</label>
                                        <div class="water-mark">
                                            <a data-toggle="modal" href='#water-mark-modal'>
                                                <img class="img-responsive" src="{{ asset('img/water_mark.png') }}" width="100" height="100"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="water-mark-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">上传水印</h4>
                        </div>
                        <form action="{{ route('water_mark_upload') }}" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                @csrf
                                <input type="file" name="water_mark" class="dropify" data-max-height="200" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M"/>
                                <span class="help-block">水印支持png、jpg、jepg 格式小于1M的图片.为保证头像质量请上传等比例的图片。并保证宽度小于200像素</span>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-flat">上传</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
