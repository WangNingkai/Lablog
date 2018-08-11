@extends('layouts.backend')
@section('title','控制台 - 单页回收站')
@section('css')
    {!! icheck_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>回收站<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('page_manage') }}">单页管理</a></li>
                <li class="active">单页回收站</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">单页回收站</h3>
                            <span>共 {{ $pages->total() }}篇</span>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th style="">#</th>
                                    <th>标题</th>
                                    <th>删除时间</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach($pages as $page)
                                    <tr>
                                        <td><input type="checkbox" value="{{$page->id}}" name="pid" class="i-checks"></td>
                                        <td>{{$page->title}}</td>
                                        <td>{{$page->deleted_at}}</td>
                                        <td>
                                            <a class="text-green restorePage"><i class="fa fa-recycle"></i></a>&nbsp;&nbsp;
                                            <a class="text-red destroyPage"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <form id="restoreForm" style="display: none;" method="POST" action="{{route('page_restore')}}">
                                @csrf
                                <input type="hidden" name="pid" id="restoreId">
                            </form>
                            <form id="destroyForm" style="display: none;" method="POST" action="{{route('page_destroy')}}">
                                @csrf
                                <input type="hidden" name="pid" id="destroyId">
                            </form>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="pull-left">
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectAll('pid')">全选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectEmpty('pid')">全不选</a>
                                <a href="javascript:void(0)" class="btn btn-primary btn-flat" onclick="selectReverse('pid')">反选</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-flat" id="destroySelectedPage">彻底删除选定</a>
                                <a href="javascript:void(0)" class="btn btn-success btn-flat" id="restoreSelectedPage">恢复选定</a>
                            </div>
                            {{ $pages->links('vendor.pagination.adminlte') }}
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
