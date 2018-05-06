@extends('layouts.admin')
@section('title','文章管理')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('tpl/plugins/dataTables/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
    {!! datatables_css() !!}
    <style>
        .editArticle :hover,
        .delArticle :hover {
            color: #000;
        }
    </style>
    <script>
        var manageArticleUrl = "{{route('article_manage')}}"
        var deleteArticleUrl = "{{route('article_delete')}}"
    </script>
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>文章管理</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('admin/home')}}">主页</a>
            </li>
            <li>
                <strong>文章管理</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('article_add') }}" class="btn btn-primary">添加文章</a>
            <a href="{{ route('tag_manage') }}" class="btn btn-primary">标签管理</a>
            <a href="{{ route('category_manage') }}" class="btn btn-primary">栏目管理</a>
        </div>
    </div>
@stop
@section('content')

    <table class="table articleTable table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th></th>
            <th>标题</th>
            <th>栏目</th>
            <th>阅读量</th>
            <th>状态</th>
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
                <td>{{$article->category_name}}</td>
                <td>{{$article->click}}</td>
                <td>
                    @if($article->status==1)
                        <span class="text-success">已发布</span>
                    @else
                        <span class="text-danger">未发布</span>
                    @endif
                </td>
                <td>
                    <a class="text-success editArticle" href="{{route('article_edit',$article->id)}}"><i
                            class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                    <a class="text-danger delArticle"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th>标题</th>
            <th>栏目</th>
            <th>阅读量</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </tfoot>
    </table>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectAll('aid')">全选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectEmpty('aid')">全不选</a>
    <a href="javascript:void(0)" class="btn btn-primary" onclick="selectReverse('aid')">反选</a>
    <a href="javascript:void(0)" class="btn btn-danger" id="delSelectedArticle">删除选定</a>
    <form id="deleteForm" style="display: none;" method="POST" action="{{route('article_delete')}}">
        {{ csrf_field() }}
        <input type="hidden" name="aid" id="deleteId">
    </form>
@stop
@section('js')
    {!! datatables_js() !!}
    {!! icheck_js() !!}
    {!! validate_js() !!}
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
