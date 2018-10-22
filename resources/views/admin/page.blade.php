@extends('layouts.backend')
@section('title','控制台 - 单页管理')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>单页管理
                <small>LABLOG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">单页管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="pull-left">
                                <a href="{{ route('page_create') }}" class="btn btn-success btn-flat"><i
                                        class="fa fa-plus-circle"></i>&nbsp;添加单页</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('page_trash') }}" class="btn btn-danger btn-flat"><i
                                        class="fa fa-trash"></i>&nbsp;回收站</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">全部单页</h3>
                            <span>共 {{ $pages->total() }}篇</span>
                            <form action="{{ route('page_manage') }}" method="get" style="display: inline-flex"
                                  class="pull-right">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control" placeholder="搜索标题">

                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i
                                                    class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>标题</th>
                                    <th>链接</th>
                                    <th>点击量</th>
                                    <th>创建时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!blank($pages))
                                    @foreach($pages as $page)
                                        <tr>
                                            <td><label><input type="checkbox" value="{{$page->id}}" name="pid"
                                                              class="i-checks"></label></td>
                                            <td><a class="text-black"
                                                   href="{{ route('page',$page->id) }}">{{ $page->title }}</a></td>
                                            <td>{{ route('page',$page->id) }}</td>
                                            <td>{{$page->click}}</td>
                                            <td>{{ \App\Helpers\Extensions\Tool::transformTime($page->created_at) }}</td>
                                            <td>{!! $page->status_tag !!}</td>
                                            <td>
                                                <a href="{{ route('page_edit',$page->id) }}" class="text-green">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>&nbsp;&nbsp;
                                                <a href="javascript:void(0)" class="text-red delPage">
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
                            <form id="deleteForm" style="display: none;" action="{{ route('page_delete') }}"
                                  method="post">
                                @csrf
                                <input type="hidden" name="pid" id="deleteId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectAll('pid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectEmpty('pid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat"
                                   onclick="selectReverse('pid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat"
                                   id="delSelectedPage">删除选定</a>
                            </div>
                            {{ $pages->appends(request()->input())->links('vendor.pagination.adminlte') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
