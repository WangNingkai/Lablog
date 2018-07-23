@extends('layouts.backend')
@section('title','控制台 - 编辑文章')
@section('css')
{!! icheck_css() !!}
{!! editor_css() !!}
@stop
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>编辑文章<small>LABLOG</small></h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard_home') }}"><i class="fa fa-dashboard"></i> 首页</a></li>
                <li><a href="#">内容管理</a></li>
                <li class="active">编辑文章</li>
            </ol>
        </section>
        <section class="content container-fluid">
            <form role="form"  method="POST" action="{{route('article_update',$article->id)}}" id="editArticleForm">
            @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i>&nbsp;发布</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">编辑文章</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group {{$errors->has('title')?'has-error':''}}">
                                    <label for="title">标题：</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="请输入标题"  value="{{ old('title')?old('title'):$article->title }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('title') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('category_id')?'has-error':''}}">
                                    <label for="category_id">栏目：</label>
                                    <select class="form-control {{$errors->has('category_id')?'has-error':''}}" name="category_id" id="category_id">
                                        <option value="">请选择栏目</option>
                                        {!! $category !!}
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('category_id') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('tag_ids')?'has-error':''}}">
                                    <label for="tag_ids">标签：</label>
                                    <div class="checkbox">
                                        @foreach( $tag as $tag_v)
                                            <label><input type="checkbox" class="i-checks" value="{{$tag_v->id}}" name="tag_ids[]" @if(in_array($tag_v->id, $article->tag_ids)) checked="checked" @endif>&nbsp;{{$tag_v->name}}</label>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('tag_ids'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('tag_ids') }}</strong></span>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('author')?'has-error':''}}">
                                    <label for="author">作者：</label>
                                    <input type="text" class="form-control" name="author" id="author" placeholder="在此输入作者"  value="{{old('author')?old('author'):$article->author}}">
                                    @if ($errors->has('author'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('author') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('keywords')?'has-error':''}}">
                                    <label for="keywords">关键词：</label>
                                    <input type="text" class="form-control" name="keywords" id="keywords" placeholder="请输入关键词" value="{{old('keywords')?old('keywords'):$article->keywords}}">
                                        @if ($errors->has('keywords'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('keywords') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('description')?'has-error':''}}">
                                    <label for="description">描述：</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="请输入描述" value="{{old('description')?old('description'):$article->description}}">
                                        @if ($errors->has('description'))
                                        <span class="help-block "><strong><i class="fa fa-times-circle-o"></i>{{ $errors->first('description') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('status')?'has-error':''}}">
                                    <label>发布：</label>
                                    <div class="radio">
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="1"
                                               @if($article->status == 1) checked="checked" @endif> &nbsp; 是
                                        </label>
                                        <label class="i-checks">
                                            <input type="radio" name="status" value="0"
                                                @if($article->status == 0) checked="checked" @endif> &nbsp; 否
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
                                        <textarea name="content" style="display:none;">{{old('content')?old('content'):$article->content}}</textarea>
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
