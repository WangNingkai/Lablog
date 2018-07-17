<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;
use App\Events\OperationEvent;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        // 记录登录信息
        $user = $event->user;
        $user->last_login_at = Carbon::now();
        $user->last_login_ip = request()->ip();
        $user->save();

        // 写入操作日志
        event(new OperationEvent(Auth::user()->name,'管理员登录', Request::getClientIp(), time()));

    }
}
