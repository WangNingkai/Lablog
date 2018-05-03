@extends('layouts.admin')
@section('title','栏目管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .editCategory :hover,
        .delCategory :hover {
            color: #000;
        }
    </style>
    <script>
        var manageCategoryUrl = "{{route('category_manage')}}"
        var destroyCategoryUrl = "{{route('category_destroy')}}"
    </script>
@stop @section('page-heading')
    <div class="col-sm-4">
        <h2>栏目管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>栏目管理</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('category_add') }}" class="btn btn-primary">添加栏目</a>
            <a href="{{ route('tag_manage') }}" class="btn btn-primary">标签管理</a>
            <a href="{{ route('article_manage') }}" class="btn btn-primary">文章管理</a>
        </div>
    </div>
@stop @section('content')
    <table class="table categoryTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>栏目名</th>
            <th>父级栏目</th>
            <th>文章数</th>
            <th>排序权重</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    <input type="checkbox" value="{{$category->id}}" name="cid">
                </td>
                <td>{{$category->name}}</td>
                <td>{{$category->p_name}}</td>
                <td>{{$category->article_count}}</td>
                <td>{{$category->sort}}</td>
                <td>
                    <a class="text-success editCategory" href="{{route('category_edit',$category->id)}}">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>&nbsp;&nbsp;
                    <a class="text-danger delCategory">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>栏目名</th>
            <th>父级栏目</th>
            <th>文章数</th>
            <th>排序权重</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('cid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('cid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('cid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedCategory">删除选定</a>
    <form id="deleteForm" style="display: none;" method="POST" action="{{route('category_destroy')}}">
        {{ csrf_field() }}
        <input type="hidden" name="cid" id="deleteId">
    </form>
@stop @section('js')
    <script src="{{asset('tpl/plugins/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/jquery-validate/messages_zh.min.js')}}"></script>
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".categoryTable").dataTable({
                language: {
                    url: "{{asset('tpl/plugins/dataTables/Chinese.json')}}"
                },
                "columns": [{
                    "orderable": false
                }, null, null, null, null, {
                    "orderable": false
                },],
            });
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });
    </script>
@stop
