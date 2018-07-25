@extends('layouts.backend')
@section('title','控制台 - 关于页面')
@section('css')
    {!! editor_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>关于页面<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">我的站点</a></li>
                <li class="active">关于页面</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form" method="POST" action="{{route('about_update')}}">
            @csrf
                 <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i>&nbsp;提交</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class=" form-group {{$errors->has('content')?'has-error':''}}">
                            @if ($errors->has('content'))
                                <span class="help-block"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('content') }}</strong></span>
                            @endif
                            <div id="editormd_id">
                                <textarea name="content" style="display:none;">{{$content}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@stop
@section('js')
    {!! editor_js() !!}
    {!! editor_config('editormd_id') !!}
@stop
