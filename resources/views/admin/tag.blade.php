@extends('layouts.backend')
@section('title','控制台 - 标签管理')
@section('css')

@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>标签管理<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">标签管理</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">全部标签</h3>
                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right" placeholder="搜索">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-responsive">
                                <tr>
                                    <th style="">#</th>
                                    <th>标签名</th>
                                    <th>标识</th>
                                    <th>文章数</th>
                                    <th style="">操作</th>
                                </tr>
                                @foreach ($tags as $tag)
                                <tr>
                                    <td>{{$tag->id}}.</td>
                                    <td>{{$tag->name}}</td>
                                    <td>
                                        {{$tag->flag}}
                                    </td>
                                    <td>
                                        {{$tag->article_count}}
                                    </td>
                                    <td>
                                        <a href="#" class="text-green">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="#" class="text-red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            {{ $tags->links('vendor.pagination.simple-adminlte') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form role="form"  method="POST" action="{{route('tag_store')}}">
                        {{ csrf_field() }}
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">新建标签</h3>
                            </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="name">标签名：</label>
                                    <input type="name" class="form-control" name="name" id="old_password" placeholder="请输入标签名">
                                    @if ($errors->has('name'))
                                        <span class="help-block text-red"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="flag">标识：</label>
                                    <input type="text" class="form-control" name="flag" id="flag" placeholder="请输入标签标识">
                                    @if ($errors->has('flag'))
                                        <span class="help-block text-red"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('flag') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-flat">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@stop
@section('js')

@stop
