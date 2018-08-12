<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $status = Cache::get('cache:config')['site_status'];
        # 判断是否关站
        if ($status == 0) {
            return response()->view('home.close');
        }
        $route = Route::currentRouteName();
        $allowMessage = Cache::get('cache:config')['site_allow_message'];
        $allowSubscribe = Cache::get('cache:config')['site_allow_subscribe'];
        if($route == 'message' && $allowMessage == 0)
        {
            return abort(404);
        }
        if($route == 'subscribe' && $allowSubscribe == 0)
        {
            return abort(404);
        }
        return $next($request);
    }
}
