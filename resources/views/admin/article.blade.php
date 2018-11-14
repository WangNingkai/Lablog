@extends('layouts.backend')
@section('title','控制台 - 文章管理')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>文章管理
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">文章管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            <form action="{{ route('article_manage') }}" method="get">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control select2" name="category" id="category_id">
                                            <option value="0">请选择栏目</option>
                                            {!! $categories !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="keyword" class="form-control" placeholder="搜索标题"
                                               value="{{ request()->input('keyword') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-search"></i>&nbsp;搜索
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部文章</h3>
                            <span>共 {{ $articles->total() }}篇</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>标题</th>
                                    <th>栏目</th>
                                    <th>点击量</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!blank($articles))
                                    @foreach($articles as $article)
                                        <tr>
                                            <td><input type="checkbox" value="{{$article->id}}" name="aid"
                                                       class="i-checks"></td>
                                            <td><a class="text-black"
                                                   href="{{ route('article',$article->id) }}">{{ $article->title }}</a>
                                            </td>
                                            <td>{{$article->category->name}}</td>
                                            <td>{{$article->click}}</td>
                                            <td>{{ \App\Helpers\Extensions\Tool::transformTime($article->created_at) }}</td>
                                            <td>{!! $article->top_tag !!} {!! $article->status_tag !!}</td>
                                            <td>
                                                <a href="{{ route('article_edit',$article->id) }}" class="text-green">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>&nbsp;&nbsp;
                                                <a href="javascript:void(0)" class="text-red delArticle">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td valign="top" colspan="7">表中数据为空</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <form id="deleteForm" style="display: none;" action="{{ route('article_delete') }}"
                                  method="post">
                                @csrf
                                <input type="hidden" name="aid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectAll('aid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectEmpty('aid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectReverse('aid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="delSelectedArticle">删除选定</a>
                            </div>
                            {{ $articles->appends(request()->input())->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
