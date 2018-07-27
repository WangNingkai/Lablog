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
                        <div class="box-header">
                            <h3 class="box-title">全部文章</h3>
                            <span>共 {{ $articles->total() }}篇</span>
                            <form action="{{ route('article_search') }}" method="get" style="display: inline-flex" class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="搜索标题">

                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
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
                                    <td>{!! $article->status_tag !!}</td>
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
                                @csrf
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
                            @if(request()->has('keyword'))
                                {{ $articles->appends(['keyword' => request()->input('keyword')])->links('vendor.pagination.adminlte') }}
                                @else
                                {{ $articles->links('vendor.pagination.adminlte') }}
                            @endif
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
