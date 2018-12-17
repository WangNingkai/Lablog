<?php

namespace App\Http\Middleware;

use App\Helpers\Extensions\Tool;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $status = Tool::config('site_status');
        // 判断是否关站
        if ($status == 0) {
            return response()->view('home.close');
        }
        $route = Route::currentRouteName();
        // 是否开启订阅或留言
        $allowMessage = Tool::config('site_allow_message');
        $allowSubscribe = Tool::config('site_allow_subscribe');
        if ($route == 'message' && $allowMessage == 0) {
            return abort(404);
        }
        if ($route == 'subscribe' && $allowSubscribe == 0) {
            return abort(404);
        }

        return $next($request);
    }
}
