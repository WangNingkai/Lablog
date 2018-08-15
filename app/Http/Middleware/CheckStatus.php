<?php

namespace App\Http\Middleware;

use App\Models\Config;
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
        $status = Cache::remember('cache:config:site_status', 1440, function () {
            return Config::query()->where('name', 'site_status')->value('value');
        });
        # 判断是否关站
        if ($status == 0) {
            return response()->view('home.close');
        }
        $route = Route::currentRouteName();
        $allowMessage = Cache::remember('cache:config:site_allow_message', 1440, function () {
            return  Config::query()->where('name', 'site_allow_message')->value('value');
        });
        $allowSubscribe = Cache::remember('cache:config:site_allow_subscribe', 1440, function () {
            return  Config::query()->where('name', 'site_allow_subscribe')->value('value');
        });
        if ($route == 'message' && $allowMessage == 0) {
            return abort(404);
        }
        if ($route == 'subscribe' && $allowSubscribe == 0) {
            return abort(404);
        }
        return $next($request);
    }
}
