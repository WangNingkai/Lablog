@extends('layouts.backend')
@section('title','控制台 - 留言管理')
@section('css')
    <script>
        var showMessageUrl = "{{route('message_show')}}"
    </script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>留言管理
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">留言管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部留言</h3>
                            <span>共{{ $messages->total() }}个</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>昵称</th>
                                    <th>邮箱</th>
                                    <th>内容</th>
                                    <th>时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!blank($messages))
                                    @foreach ($messages as $message)
                                        <tr>
                                            <td><input type="checkbox" value="{{$message->id}}" name="mid"
                                                       class="i-checks"></td>
                                            <td>{{$message->nickname}}</td>
                                            <td>{{$message->email}}</td>
                                            <td>{{ \App\Helpers\Extensions\Tool::subStr($message->content, 0, 20, true) }}</td>
                                            <td>{{$message->created_at}}</td>
                                            <td>{!! $message->status_tag !!}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-green showMessage">
                                                    查看
                                                </a>&nbsp;&nbsp;
                                                <a href="javascript:void(0)" class="text-red delMessage">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td valign="top" colspan="7">表中数据为空</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <form id="deleteForm" style="display: none;" method="POST"
                                  action="{{route('message_destroy')}}">
                                @csrf
                                <input type="hidden" name="mid" id="deleteId">
                            </form>
                            <form id="checkForm" style="display: none;" method="POST"
                                  action="{{route('message_check')}}">
                                @csrf
                                <input type="hidden" name="mid" id="checkId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectAll('mid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectEmpty('mid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectReverse('mid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedMessage">删除选定</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-flat" id="checkSelectedMessage">审核选定</a>
                            </div>
                            {{ $messages->links('vendor.pagination.adminlte') }}
                        </div>
                        <div class="modal fade" id="messageModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" role="form" method="POST"
                                          action="{{route('message_reply')}}">
                                        @csrf
                                        <input type="hidden" name="id" id="mid">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                &times;
                                            </button>
                                            <h4 class="modal-title">留言审核</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">昵称</label>
                                                <div class="col-sm-10">
                                                    <p class="form-control-static" id="nickname"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">邮箱</label>
                                                <div class="col-sm-10">
                                                    <p class="form-control-static" id="email"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">内容</label>
                                                <div class="col-sm-10">
                                                    <p class="form-control-static" id="content"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">时间</label>
                                                <div class="col-sm-10">
                                                    <p class="form-control-static" id="created_at"></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="reply">回复</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" style="resize: none;" rows="3"
                                                              cols="4" name="reply" id="reply"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-flat">回复</button>
                                            <button type="button" class="checkMessage btn btn-success btn-flat">通过
                                            </button>
                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">
                                                关闭
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
