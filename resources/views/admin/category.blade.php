@extends('layouts.backend')
@section('title','控制台 - 栏目管理')
@section('css')
{!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>栏目管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">栏目管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部栏目</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                                <tr>
                                    <th style="">#</th>
                                    <th>栏目名</th>
                                    <th>排序权重</th>
                                    <th>文章数</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach($categories as $category)
                                <tr>
                                    <td><input type="checkbox" value="{{$category->id}}" name="cid" class="i-checks"></td>
                                    <td>{!! $category->name !!}</td>
                                    <td>
                                        {{$category->sort}}
                                    </td>
                                    <td>
                                        {{$category->article_count}}
                                    </td>
                                    <td>
                                        <a href="{{route('category_edit',$category->id)}}" class="text-green">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="text-red delCategory">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('category_destroy')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="cid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('cid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('cid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('cid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedCategory">删除选定</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form role="form"  method="POST" action="{{route('category_store')}}" id="createCategoryForm">
                        {{ csrf_field() }}
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建栏目</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('name')?'has-error':''}}">
                                    <label for="name">栏目名：</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入栏目名称"  value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('pid')?'has-error':''}}">
                                    <label for="pid">父级栏目</label>
                                    <select class="form-control" name="pid" id="pid">
                                        <option value="">请选择栏目</option>
                                        <option value="0">一级栏目</option>
                                        @foreach($levelOne as $cate)
                                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pid'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('pid') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('flag')?'has-error':''}}">
                                    <label for="flag">标识：</label>
                                    <input type="text" class="form-control" name="flag" id="flag" placeholder="请输入栏目标识"  value="{{old('flag')}}">
                                    @if ($errors->has('flag'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('flag') }}</strong></span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('sort')?'has-error':''}}">
                                    <label for="sort">排序权重：</label>
                                    <input type="text" class="form-control" name="sort" id="sort" placeholder="请输入数字，默认为0"  value="{{old('sort')}}">
                                    @if ($errors->has('sort'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('sort') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('keywords')?'has-error':''}}">
                                    <label for="keywords">关键词：</label>
                                    <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键词" value="{{ old('keywords') }}">
                                        @if ($errors->has('keywords'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('keywords') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('description')?'has-error':''}}">
                                    <label for="description">描述：</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="请输入描述" value="{{ old('description') }}">
                                        @if ($errors->has('description'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('description') }}</strong></span>
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
