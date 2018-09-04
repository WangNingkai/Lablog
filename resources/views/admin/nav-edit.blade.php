@extends('layouts.backend')
@section('title','控制台 - 菜单编辑')
@section('before_css')
    {!! select2_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>菜单编辑<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('nav_manage') }}">菜单管理</a></li>
                <li class="active">菜单编辑</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <form role="form"  method="POST" action="{{ route('nav_update',$editNav->id)}}" id="editNavForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑菜单</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('type')?'has-error':''}}">
                                    <label for="type">菜单类型：</label>
                                    <select class="form-control select2" name="type" id="type" >
                                        <option value="">菜单类型</option>
                                        @foreach (\App\Models\Nav::TYPE as $key => $type )
                                            <option value="{{ $key }}" @if (!is_null(old('type')) && old( 'type') == $key) selected="selected" @elseif( $editNav->type == $key) selected="selected" @endif>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('type') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('parent_id')?'has-error':''}}">
                                    <label for="parent_id">父级菜单</label>
                                    <select class="form-control select2" name="parent_id" id="parent_id">
                                        <option value="">请选择菜单</option>
                                        <option value="0" selected="selected">一级菜单</option>
                                        @foreach($emptyNavs as $empty_nav)
                                            <option value="{{ $empty_nav->id }}" @if (!is_null(old('parent_id')) && old( 'parent_id') ==  $empty_nav->id) selected="selected" @elseif( $editNav->parent_id == $empty_nav->id) selected="selected" @endif>{{ $empty_nav->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">仅可选空菜单类型，默认为1级菜单</span>
                                    @if ($errors->has('parent_id'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('parent_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">菜单名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入菜单名称"  value="{{ old('name')?old('name'):$editNav->name }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('url')?'has-error':''}}" id="url-group">
                                    <label for="url">链接：</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="请输入链接"  value="{{ old('url')?old('url'):$editNav->url }}">
                                    <span class="help-block text-red">仅对链接菜单有效，链接前请加上协议(如:https://xxx.com)</span>
                                    @if ($errors->has('url'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('url') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('sort')?'has-error':''}}">
                                    <label for="sort">排序权重：</label>
                                    <input type="text" class="form-control" name="sort" id="sort" placeholder="请输入数字，默认为1"  value="{{ old('sort')?old('sort'):$editNav->sort }}">
                                    @if ($errors->has('sort'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('sort') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>状态：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Nav::STATUS_DISPLAY }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Nav::STATUS_DISPLAY) checked="checked" @elseif($editNav->status == \App\Models\Nav::STATUS_DISPLAY ) checked="checked"  @endif> &nbsp;显示
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Nav::STATUS_HIDE }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Nav::STATUS_HIDE) checked="checked" @elseif($editNav->status == \App\Models\Nav::STATUS_HIDE ) checked="checked"  @endif> &nbsp;隐藏
                                        </label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('status') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部菜单</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>菜单名</th>
                                    <th>类型</th>
                                    <th>排序权重</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($navs as $nav)
                                    <tr>
                                        <td><label><input type="checkbox" value="{{$nav->id}}" name="nid" class="i-checks"></label></td>
                                        <td>{!! $nav->name !!}</td>
                                        <td>
                                            {{$nav->type_name}}
                                        </td>
                                        <td>
                                            {{$nav->sort}}
                                        </td>
                                        <td>
                                            {!! $nav->status_tag !!}
                                        </td>
                                        <td>
                                            <a href="{{route('nav_edit',$nav->id)}}" class="text-green">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class="text-red delNav">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('nav_destroy')}}" method="post">
                                @csrf
                                <input type="hidden" name="nid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('nid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('nid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('nid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedNav">删除选定</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@stop
@section('js')
    {!! select2_js() !!}
    <script>
        $(function () {
            let type_empty = "{{ \App\Models\Nav::TYPE_EMPTY }}";
            let type_menu = "{{ \App\Models\Nav::TYPE_MENU }}";
            let type_page = "{{ \App\Models\Nav::TYPE_PAGE }}";
            let type_archive = "{{ \App\Models\Nav::TYPE_ARCHIVE }}";
            $("#type").select2();
            let parent_id_select = $('#parent_id').select2();
            $("#type").on("change",function(){
                let type = $(this).val();
                console.log(type);
                if ( type_empty == type ||  type_menu == type ){
                    parent_id_select.val("0").trigger("change");
                    $("#url-group").attr("style","display:none");
                    $("#parent_id").attr("disabled","disabled");
                }else if( type_page == type )
                {
                    $("#url").attr("placeholder","请输入单页链接，或单页ID");
                    $("#url-group").removeAttr("style");
                    $("#parent_id").removeAttr("disabled");
                } else if( type_archive == type )
                {
                    $("#url-group").attr("style","display:none");
                    $("#parent_id").removeAttr("disabled");
                }else{
                    $("#url-group").removeAttr("style");
                    $("#parent_id").removeAttr("disabled");
                }
            });
        });
    </script>

@stop
