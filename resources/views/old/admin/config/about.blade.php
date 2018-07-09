@extends('layouts.admin')
@section('title','关于')
@section('css')
    {!! editor_css() !!}
@stop
@section('page-heading')
    <div class="col-sm-4">
        <h2>关于</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <strong>关于</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>关于页面内容</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" role="form" id="about-form" method="POST" action="{{route('about_update')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-2">
                        <a href="javascript:;"
                           onclick="event.preventDefault();document.getElementById('about-form').submit();"
                           class="btn btn-primary">
                            <i class="fa fa-check"></i> 提交
                        </a>
                    </div>
                </div>
                <div class=" form-group">
                    <div class="col-sm-12">
                        <p class="form-control-static text-danger">{{$errors->first('content')}}</p>
                        <div id="editormd_id">
                            <textarea name="content" style="display:none;">{{$content}}</textarea>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop
@section('js')
    {!! editor_js() !!}
    {!! editor_config('editormd_id') !!}
@stop
