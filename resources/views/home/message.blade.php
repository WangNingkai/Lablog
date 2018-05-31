@extends('layouts.home')
@section('title', $config['site_name'].'留言板')
@section('content')
    <div class="col-sm-8">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center article-title">
                            <h1>
                                留言板
                            </h1>
                            <p>在这里您可以对网站提出建议，或咨询相关问题</p>
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="content">
                            <div class="comments">
                                <section class="comments-list">
                                    <!--留言  -->
                                    @foreach($messages as $message)
                                        <div class="comment">
                                            <a href="javascript:void(0)" class="avatar">
                                                <img src="{{asset('tpl/img/user_avatar.png')}}" alt="{{$message->nickname}}">
                                            </a>
                                            <div class="content">
                                                <div class="pull-right text-muted">{{$message->created_at}}</div>
                                                <div><a href="javascript:void(0)"><span
                                                            class="commenter">{{$message->nickname}}</span></a></div>
                                                <div class="text">{{$message->content}}</div>
                                            </div>
                                            @isset($message->reply)
                                                <div class="comments-list">
                                                    <!--站长回复留言  -->
                                                    <div class="comment">
                                                        <a href="javascript:void(0)" class="avatar">
                                                            <img src="{{asset('tpl/img/admin_avatar.png')}}" alt="站长">
                                                        </a>
                                                        <div class="content">
                                                            <div
                                                                class="pull-right text-muted">{{$message->updated_at}}</div>
                                                            <div><a href="javascript:void(0)"><span
                                                                        class="commenter">站长</span></a>
                                                                <span class="text-muted">回复</span>
                                                                <a href="javascript:void(0)"><span class="commented">{{$message->nickname}}</span></a>
                                                            </div>
                                                            <div class="text">{{$message->reply}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endisset
                                        </div>
                                    @endforeach
                                </section>
                                @include('errors.validator')
                                <footer>
                                    <div class="reply-form" id="commentReplyForm">
                                        <a href="javascript:void(0)" class="avatar"><img src="{{asset('tpl/img/user_avatar.png')}}" alt=""></a>
                                        <form class="form" id="messageForm" action="{{route('message_store')}}" method="post">
                                        {{ csrf_field() }}
                                            <div class="form-group">
                                                <textarea class="form-control new-comment-text" name="content"
                                                            id="message" rows="2" placeholder="撰写留言..."></textarea>
                                            </div>
                                            <div class="form-group comment-user">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <input type="email" name="email" class="form-control"
                                                                    id="email" placeholder="输入电子邮件（不会在留言显示）*" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <input type="text" name="nickname" class="form-control"
                                                                    id="nickname" placeholder="输入评论显示名称 *" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button type="submit"
                                                                class="btn btn-block btn-outline btn-primary">留言
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

