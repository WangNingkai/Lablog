<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Events\OperationEvent;
use App\Helpers\Extensions\UserExt;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //评论列表出现置顶广告，无评论则显示暂无评论空数组
        $user = $event->user;
        $user->last_login_at = time();
        $user->last_login_ip = request()->ip();
        $user->save();
        event(new OperationEvent(UserExt::getAttribute('name'),'管理员登录', request()->ip(), time()));
    }
}
