@extends('layouts.backend')
@section('title','控制台 - 文章回收站')
@section('css')
{!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>回收站<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">文章回收站</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">文章回收站</h3>
                            <span>共 {{ $articles->total() }}篇</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th style="">#</th>
                                    <th>标题</th>
                                    <th>删除时间</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach($articles as $article)
                                <tr>
                                    <td><input type="checkbox" value="{{$article->id}}" name="aid" class="i-checks"></td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->deleted_at}}</td>
                                    <td>
                                       <a class="text-green restoreArticle"><i class="fa fa-recycle"></i></a>&nbsp;&nbsp;
                                        <a class="text-red destroyArticle"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <form id="restoreForm" style="display: none;" method="POST" action="{{route('article_restore')}}">
                                @csrf
                                <input type="hidden" name="aid" id="restoreId">
                            </form>
                            <form id="destroyForm" style="display: none;" method="POST" action="{{route('article_destroy')}}">
                                @csrf
                                <input type="hidden" name="aid" id="destroyId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('aid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('aid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('aid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="destroySelectedArticle">彻底删除选定</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-flat" id="restoreSelectedArticle">恢复选定</a>
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
