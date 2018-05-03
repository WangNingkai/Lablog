@extends('layouts.admin')
@section('title','添加文章')
@section('css')
    <link href="{{asset('tpl/plugins/iCheck/custom.css')}}" rel="stylesheet"> {!! editor_css() !!}
    <script>
        var createArticleUrl = "{{url('article/create')}}";
        var manageArticleUrl = "{{url('article/manage')}}"
    </script>
@stop @section('page-heading')
    <div class="col-sm-4">
        <h2>新文章</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('admin_home')}}">主页</a>
            </li>
            <li>
                <a href="{{route('article_manage')}}">文章管理</a>
            </li>
            <li>
                <strong>添加文章</strong>
            </li>
        </ol>
    </div>
@stop
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>文章信息</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form class="form-horizontal" role="form" id="addArticleForm" method="POST"
                  action="{{ route('article_create') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-5">
                        <input type="text" name="title" class="form-control" placeholder="在此输入文章标题"
                               value="{{ old('title') }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('title')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">栏目</label>
                    <div class="col-sm-5">
                        <select class="form-control m-b" name="category_id">
                            <option value="">请选择栏目</option>
                            {{!! $category !!}}
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('category_id')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标签</label>
                    <div class="col-sm-5">
                        @foreach( $tag as $tag_v)
                            <label class="checkbox-inline i-checks">
                                <input type="checkbox" value="{{$tag_v->id}}" name="tag_ids[]"
                                       @if(in_array($tag_v->id, old('tag_ids', []))) checked="checked" @endif>
                                &nbsp;{{$tag_v->name}}
                            </label>
                        @endforeach
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('tag_ids')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">关键词</label>
                    <div class="col-sm-5">
                        <input type="text" name="keywords" class="form-control" placeholder="用英文逗号分隔"
                               value="{{ old('keywords') }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('keywords')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章描述</label>
                    <div class="col-sm-5">
                        <input type="text" name="description" class="form-control" placeholder="可不填，自动获取文章200字符"
                               value="{{ old('description') }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('description')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">作者</label>
                    <div class="col-sm-5">
                        <input type="text" name="author" class="form-control" placeholder="在此输入作者"
                               value="{{ old('author')?old('author'):Auth::user()->name }}">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('author')}}</p>
                    </div>
                </div>
                <div class=" form-group">
                    <label class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <p class="form-control-static text-danger">{{$errors->first('content')}}</p>
                        <div id="editormd_id">
                            <textarea name="content" style="display:none;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">发布</label>
                    <div class="col-sm-5">
                        <label class="radio-inline i-checks">
                            <input type="radio" value="1" name="status" value="1"
                                   @if(old( 'status', 0)==1 ) checked="checked" @endif> &nbsp; 是
                        </label>
                        <label class="radio-inline i-checks">
                            <input type="radio" value="1" name="status" value="1"
                                   @if(old( 'status', 0)==0 ) checked="checked" @endif> &nbsp; 否
                        </label>
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('status')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
@section('js')
    <script src="{{asset('tpl/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/jquery-validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('tpl/plugins/jquery-validate/messages_zh.min.js')}}"></script>
    {!! editor_js() !!}
    {!! editor_config('editormd_id') !!}
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/validator.js')}}"></script>
    <script>
        $(function () {
            $(".i-checks").iCheck({
                checkboxClass: "icheckbox_square-green",
                radioClass: "iradio_square-green",
            });
        });
    </script>
@stop
