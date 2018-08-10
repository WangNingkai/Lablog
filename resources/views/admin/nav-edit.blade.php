@extends('layouts.backend')
@section('title','控制台 - 菜单管理')
@section('before_css')
    {!! select2_css() !!}
@stop
@section('css')
    {!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>菜单管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">菜单管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form role="form"  method="POST" action="{{ route('nav_store')}}" id="createNavForm">
                        @csrf
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建菜单</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('type')?'has-error':''}}">
                                    <label for="type">菜单类型：</label>
                                    <select class="form-control select2" name="type" id="type" >
                                        <option value="">菜单类型</option>
                                        <option value="{{ \App\Models\Nav::TYPE_EMPTY }}">空菜单</option>
                                        <option value="{{ \App\Models\Nav::TYPE_MENU }}">栏目菜单</option>
                                        <option value="{{ \App\Models\Nav::TYPE_ARCHIVE }}">归档页</option>
                                        <option value="{{ \App\Models\Nav::TYPE_PAGE }}">单页</option>
                                        <option value="{{ \App\Models\Nav::TYPE_LINK }}">外链</option>
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
                                        @foreach($emptyNavs as $nav)
                                            <option value="{{ $nav->id }}">{{ $nav->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">仅可选空菜单类型，默认为1级菜单</span>
                                    @if ($errors->has('parent_id'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('parent_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">菜单名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入菜单名称"  value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('url')?'has-error':''}}" id="url-group">
                                    <label for="url">链接：</label>
                                    <input type="text" class="form-control" name="url" id="url" placeholder="请输入链接"  value="{{old('url')}}">
                                    <span class="help-block text-red">链接前请加上协议(如:https://xxx.com)</span>
                                    @if ($errors->has('url'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('url') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('sort')?'has-error':''}}">
                                    <label for="sort">排序权重：</label>
                                    <input type="text" class="form-control" name="sort" id="sort" placeholder="请输入数字，默认为1"  value="{{old('sort')}}">
                                    @if ($errors->has('sort'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('sort') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>状态：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Nav::STATUS_DISPLAY }}"
                                                   @if(old( 'status', \App\Models\Nav::STATUS_DISPLAY)==\App\Models\Nav::STATUS_DISPLAY ) checked="checked" @endif> &nbsp;显示
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Nav::STATUS_HIDE }}"
                                                   @if(old( 'status', \App\Models\Nav::STATUS_HIDE)==\App\Models\Nav::STATUS_HIDE ) checked="checked" @endif> &nbsp;隐藏
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
            </div>
        </section>
    </div>
@stop
@section('js')
    {!! select2_js() !!}
    {!! icheck_js() !!}
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-blue",
                radioClass: "iradio_square-blue",
            });
            let type_empty = "{{ \App\Models\Nav::TYPE_EMPTY }}";
            let type_menu = "{{ \App\Models\Nav::TYPE_MENU }}";
            let type_page = "{{ \App\Models\Nav::TYPE_PAGE }}";
            let type_archive = "{{ \App\Models\Nav::TYPE_ARCHIVE }}";
            $("type").select2();
            let parent_id_select = $('#parent_id').select2();
            $("#type").on("change",function(){
                let type = $(this).val();
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
    <script src="{{ asset('js/admin.js') }}"></script>
@stop
