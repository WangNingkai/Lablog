@extends('layouts.backend')
@section('title','控制台 - 友链管理')
@section('css')
{!! icheck_css() !!}
<script>
    var editLinkUrl = "{{route('link_edit')}}"
</script>
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>友链管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">友链管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部友链</h3>
                            <span>共{{ $links->total() }}个</span>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                                <tr>
                                    <th style="">#</th>
                                    <th>友链名</th>
                                    <th>地址</th>
                                    <th>排序权重</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach ($links as $link)
                                <tr>
                                    <td><input type="checkbox" value="{{$link->id}}" name="lid" class="i-checks"></td>
                                    <td>{{$link->name}}</td>
                                    <td>
                                        {{$link->url}}
                                    </td>
                                    <td>
                                        {{$link->sort}}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="text-green editLink">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="text-red delLink">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('link_destroy')}}" method="post">
                                @csrf
                                <input type="hidden" name="lid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('lid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('lid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('lid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedLink">删除选定</a>
                            </div>
                            {{ $links->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @include('errors.validator')
                    <form role="form"  method="POST" action="{{route('link_update')}}" id="editLinkForm" style="display:none;">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑友链</h3>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="id" id="editId">
                                <div class="form-group {{$errors->has('edit_name')?'has-error':''}}">
                                    <label for="editName">友链名：</label>
                                    <input type="text" class="form-control" name="edit_name" id="editName" placeholder="请输入友链名" value="{{ old('edit_name')?old('edit_name'):'' }}">
                                    @if ($errors->has('edit_name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('edit_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('edit_url')?'has-error':''}}">
                                    <label for="url">链接：</label>
                                    <input type="text" class="form-control" name="edit_url" id="editUrl" placeholder="请输入友链链接" value="{{ old('edit_url')?old('edit_url'):'' }}">
                                     <span class="help-block text-red">链接前请加上协议(如:https://xxx.com)</span>
                                    @if ($errors->has('edit_url'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('edit_url') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('edit_sort')?'has-error':''}}">
                                    <label for="editSort">排序：</label>
                                    <input type="text" class="form-control" name="edit_sort" id="editSort" placeholder="请输入友链排序" value="{{ old('edit_sort')?old('edit_sort'):'' }}">
                                    @if ($errors->has('edit_sort'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('edit_sort') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                    <form role="form"  method="POST" action="{{route('link_store')}}" id="createLinkForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建友链</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">友链名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入友链名"  value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('url')?'has-error':''}}">
                                    <label for="url">链接：</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="请输入友链链接"  value="{{old('url')}}">
                                     <span class="help-block text-red">链接前请加上协议(如:https://xxx.com)</span>
                                    @if ($errors->has('url'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('url') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('sort')?'has-error':''}}">
                                    <label for="sort">排序：</label>
                                    <input type="text" class="form-control" name="sort" id="sort" placeholder="请输入友链链接"  value="{{old('sort')}}">
                                    @if ($errors->has('sort'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('sort') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
<script src="{{ asset('js/admin.js') }}"></script>
@stop
