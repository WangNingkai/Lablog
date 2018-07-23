<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ConfirmPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uid = Auth::id();
        $key = 'action:confirmPassword:user:'.$uid;
        $confirmed = Cache::get($key);
        // 判断是否完成密码校验，未完成跳转，完成释放缓存
        if (!$confirmed) {
            return redirect()->route('confirm_password');
        }
        Cache::forget($key);
        return $next($request);
    }
}
