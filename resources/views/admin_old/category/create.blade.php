@extends('layouts.admin')
@section('title','添加栏目')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>添加栏目</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <a href="{{route('category_manage')}}">栏目管理</a>
            </li>
            <li>
                <strong>添加栏目</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>栏目信息</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" role="form" id="addCategoryForm" method="POST"
                  action="{{ route('category_create') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">栏目名称</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" class="form-control" placeholder="请输入栏目名称"
                               value="{{old('name')}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">栏目标识</label>
                    <div class="col-sm-5">
                        <input type="text" name="flag" class="form-control" placeholder="请输入栏目标识"
                               value="{{old('flag')}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('flag')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">父级栏目</label>
                    <div class="col-sm-5">
                        <select class="form-control m-b" name="pid">
                            <option value="">请选择栏目</option>
                            <option value="0">一级栏目</option>
                            @foreach($levelOne as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('pid')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">关键词</label>
                    <div class="col-sm-5">
                        <input type="text" name="keywords" class="form-control" placeholder="请输入关键词"
                               value="{{old('keywords')}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('keywords')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-5">
                        <input type="text" name="description" class="form-control" placeholder="请输入描述"
                               value="{{old('description')}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('description')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序权重</label>
                    <div class="col-sm-5">
                        <input type="text" name="sort" class="form-control" placeholder="请输入数字，默认为0"
                               value="{{old('sort')}}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('sort')}}</p>
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
@stop
@section('js')
    {!! icheck_js() !!}
    {!! validate_js() !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });
    </script>
@stop
