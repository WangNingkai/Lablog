@extends('layouts.backend')
@section('title','控制台 - 文章管理')
@section('css')
{!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>文章管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">文章管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部文章</h3>
                            <span>共 {{ $articles->total() }}篇</span>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive">
                                <tr>
                                    <th style="">#</th>
                                    <th>标题</th>
                                    <th>栏目</th>
                                    <th>点击量</th>
                                    <th>状态</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach($articles as $article)
                                <tr>
                                    <td><input type="checkbox" value="{{$article->id}}" name="aid" class="i-checks"></td>
                                    <td><a class="text-black" href="{{route('article',$article->id)}}">{{$article->title}}</a></td>
                                    <td>{{$article->category->name}}</td>
                                    <td>{{$article->click}}</td>
                                    <td>
                                        @if($article->status==1)
                                            <span class="text-green">已发布</span>
                                        @else
                                            <span class="text-red">未发布</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('article_edit',$article->id)}}" class="text-green">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" class="text-red delArticle">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{route('article_delete')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="aid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('aid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('aid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('aid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedArticle">删除选定</a>
                            </div>
                             {{ $articles->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
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