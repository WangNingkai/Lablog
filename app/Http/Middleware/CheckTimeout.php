<?php

namespace App\Http\Middleware;

use Closure;

class CheckTimeout
{
    // 超时时间30分钟
    protected $timeout = 1800;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isLoggedIn = $request->path() != 'logout';
        if(! session('lastActivityTime')){
            app('session')->put('lastActivityTime', time());
        } elseif(time() - app('session')->get('lastActivityTime') > $this->timeout){
            app('session')->forget('lastActivityTime');
            $cookie = cookie('intend', $isLoggedIn ? url()->current() : 'admin');
            $email = $request->user()->email;
            auth()->logout();
            return route('login')->withInput(['email' => $email])->withCookie($cookie);
        }
        $isLoggedIn ? app('session')->put('lastActivityTime', time()) : app('session')->forget('lastActivityTime');
        return $next($request);
    }
}
