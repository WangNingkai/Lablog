@extends('layouts.backend')
@section('title','控制台 - 订阅管理')
@section('css')
    {!! icheck_css() !!}
    <link href="{{ asset('adminlte/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>订阅管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">其他模块</a></li>
                <li class="active">订阅管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="pull-left">
                                <a class="btn btn-success btn-flat" data-toggle="modal" href="#subscribe-modal"><i class="fa fa-plus-circle"></i>&nbsp;推送订阅消息</a>
                                <div class="modal fade" id="subscribe-modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">推送订阅消息</h4>
                                            </div>
                                            <form action="{{ route('subscribe_push') }}" method="post">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group {{$errors->has('push_time')?'has-error':''}}">
                                                        <label>推送方式：</label>
                                                        <div class="radio">
                                                            <label class="i-checks">
                                                                <input type="radio" name="push_method" value="0" id="push_now" > &nbsp; 立即推送
                                                            </label>
                                                            <label class="i-checks">
                                                                <input type="radio" name="push_method" value="1" id="push_delay"> &nbsp; 定时推送
                                                            </label>
                                                        </div>
                                                        @if ($errors->has('push_time'))
                                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('push_time') }}</strong></span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group" id="push_time" style="display: none">
                                                        <label>推送时间：</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" readonly class="form-control date" id="datetimepicker" name="push_time">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                    <div class="form-group {{$errors->has('content')?'has-error':''}}">
                                                        <label for="">订阅消息：</label>
                                                        <textarea class="form-control" rows="5" name="content" placeholder="输入 ..." style="resize: none;" required></textarea>
                                                        @if ($errors->has('content'))
                                                            <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('content') }}</strong></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-flat">推送</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部订阅</h3>
                            <span>共 {{ $subscribes->total() }}条</span>
                            <form action="{{ route('subscribe_manage') }}" method="get" style="display: inline-flex" class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="邮箱">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>id</th>
                                    <th>邮箱</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($subscribes as $subscribe)
                                    <tr>
                                        <td><label><input type="checkbox" value="{{$subscribe->id}}" name="sid" class="i-checks"></label></td>
                                        <td>{{$subscribe->id}}</td>
                                        <td>{{$subscribe->email}}</td>
                                        <td>{{ \App\Helpers\Extensions\Tool::transformTime($subscribe->created_at) }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-red delSubscribes">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('subscribe_destroy')}}" method="post">
                                @csrf
                                <input type="hidden" name="sid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('sid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('sid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('sid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedSubscribes">删除选定</a>
                            </div>
                            {{ $subscribes->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')
    {!! icheck_js() !!}
    <script src="{{ asset('adminlte/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-blue",
                radioClass: "iradio_square-blue",
            });
            $('.date').datetimepicker({
                language: 'zh-CN',
                format: 'yyyy-mm-dd hh:ii ',
                pickerPosition: "bottom-left",
                todayBtn: 1,
                todayHighlight : true,
                minuteStep: 1,
                initialDate: new Date(),
                startDate:new Date(),
                endDate: new Date(new Date().getTime() + 24 * 60 * 60 *3000),
                autoclose: true,//选中自动关闭
            }).on('changeDate', function(ev){
                if(ev.date.valueOf() < (new Date()).valueOf()){
                    swal('定时推送开始时间必须大于当前时间', ':(', 'error')
                }
            });
            let push_method =$("input[type=radio][name=push_method]");
            // 默认立即推送选中
            $("input[type=radio][name=push_method]#push_now").iCheck('check');
            push_method.on('change',function() {
                if (this.value == '0') {
                    $("div#push_time").hide();
                }else if (this.value == '1') {
                    $("div#push_time").show();
                }
            });
        });
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
@stop
