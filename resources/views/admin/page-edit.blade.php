@extends('layouts.backend')
@section('title','控制台 - 编辑单页')
@section('css')
    {!! icheck_css() !!}
    {!! editor_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>编辑单页<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="{{ route('page_manage') }}">单页管理</a></li>
                <li class="active">编辑单页</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form"  method="POST" action="{{ route('page_update',$page->id) }}" id="updatePageForm">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i>&nbsp;保存</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑单页</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('title')?'has-error':''}}">
                                    <label for="title">标题：</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="请输入标题"  value="{{ old('title')?old('title'):$page->title }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('author')?'has-error':''}}">
                                    <label for="author">作者：</label>
                                    <input type="text" class="form-control" name="author" id="author" placeholder="在此输入作者"  value="{{old('author') ? old('author') : $page->author}}">
                                    @if ($errors->has('author'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('author') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>发布：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Page::STATUS_DISPLAY }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Page::STATUS_DISPLAY) checked="checked" @elseif($page->status == \App\Models\Page::STATUS_DISPLAY ) checked="checked"  @endif> &nbsp; 是
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="{{ \App\Models\Page::STATUS_HIDE }}"
                                                   @if(!is_null(old('status')) && old( 'status') == \App\Models\Page::STATUS_HIDE) checked="checked" @elseif($page->status == \App\Models\Page::STATUS_HIDE ) checked="checked"  @endif> &nbsp; 否
                                        </label>
                                    </div>
                                    @if ($errors->has('status'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('status') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">内容</h3>
                            </div>
                            <div class="box-body">
                                <div class=" form-group {{$errors->has('content')?'has-error':''}}">
                                    @if ($errors->has('content'))
                                        <span class="help-block"><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('content') }}</strong></span>
                                    @endif
                                    <div id="editormd_id">
                                        <textarea name="content" style="display:none;">{{ old('content') ? old('content') : $page->content }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@stop
@section('js')
    {!! icheck_js() !!}
    {!! editor_js() !!}
    {!! editor_config('editormd_id') !!}
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
