@extends('layouts.admin')
@section('title','文章回收站')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    <link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <style>
        .restoreArticle :hover,
        .destroyArticle :hover {
            color: #000;
        }
    </style>
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>文章回收站</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('admin/home')}}">主页</a>
            </li>
            <li>
                <strong>文章回收站</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('article_manage') }}" class="btn btn-primary">文章管理</a>
        </div>
    </div>
@stop
@section('content')
    <table class="table articleTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>标题</th>
            <th>删除时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <td>
                    <input type="checkbox" value="{{$article->id}}" name="aid">
                </td>
                <td>{{$article->title}}</td>
                <td>{{$article->deleted_at}}</td>
                <td>
                    <a class="text-success restoreArticle"><i class="fa fa-recycle"></i></a>&nbsp;&nbsp;
                    <a class="text-danger destroyArticle"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>标题</th>
            <th>删除时间</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('aid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('aid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('aid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="destroySelectedArticle">彻底删除选定</a>
    <a href="javascript:void(0)" class="btn btn-success" id="restoreSelectedArticle">恢复选定</a>
    <form id="restoreForm" style="display: none;" method="POST" action="{{route('article_restore')}}">
        {{ csrf_field() }}
        <input type="hidden" name="aid" id="restoreId">
    </form>
    <form id="destroyForm" style="display: none;" method="POST" action="{{route('article_destroy')}}">
        {{ csrf_field() }}
        <input type="hidden" name="aid" id="destroyId">
    </form>
@stop
@section('js')
    @parent
    <!-- <script src="{{asset('tpl/plugins/dataTables/jquery.dataTables.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/iCheck/icheck.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/jquery-validate/jquery.validate.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <!-- <script src="{{asset('tpl/plugins/jquery-validate/messages_zh.min.js')}}"></script> -->
    <script src="https://cdn.bootcss.com/jquery-validate/1.17.0/localization/messages_zh.min.js"></script>
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".articleTable").dataTable({
                language: {
                    url: "{{asset('tpl/plugins/dataTables/Chinese.json')}}"
                },
                "columns": [{
                    "orderable": false
                }, null, null, {
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
