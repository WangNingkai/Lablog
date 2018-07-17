@extends('layouts.frontend')
@section('title', '留言板')
@section('content')
    <div class="col-md-8">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3>
                                留言板
                            </h3>
                            <p>在这里您可以对网站提出建议，或咨询相关问题</p>
                            <div class="hr-line-dashed"></div>
                        </div>
                        @foreach($messages as $message)
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="{{asset('img/user_avatar.png')}}" alt="{{$message->nickname}}">
                                <span class="username">
                                <a href="#">{{ $message->nickname }}</a>
                                </span>
                                <span class="description">{{ $message->created_at }}</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                {{ $message->content }}
                            </p>
                            @isset($message->reply)
                                <div class="post reply-post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ $config['site_admin_avatar'] }}" alt="{{ $config['site_admin'] }}">
                                        <span class="username">
                                            <a href="#">站长回复</a>
                                        </span>
                                        <span class="description">{{ $message->updated_at }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        {{ $message->reply }}
                                    </p>
                                </div>
                            @endisset
                        </div>
                        @endforeach
                        <div class="post clearfix">
                            <h4 class="text-bold">给我留言：</h4>
                            @include('errors.validator')
                            <form role="form" action="{{route('message_store')}}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <textarea class="form-control" style="resize: none;" rows="3" cols="4" name="content" placeholder="请输入留言" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <input type="text" class="form-control" name ="nickname"placeholder="输入留言显示名称 *" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="email" class="form-control" name="email" placeholder="输入电子邮件（不会在留言显示）*" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <button type="submit" class="btn btn-flat btn-block bg-green">留言</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

