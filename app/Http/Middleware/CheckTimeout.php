<?php

namespace App\Http\Middleware;

use App\Helpers\Extensions\UserExt;
use Closure;
use Illuminate\Support\Facades\Session;

class CheckTimeout
{
    # 超时时间30分钟
    protected $timeout = 1800;

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
        $isLoggedIn = $request->path() != 'logout';
        if (!$lastActivityTime = Session::get('lastActivityTime')) {
            Session::put('lastActivityTime', time());
        } elseif (time() - $lastActivityTime > $this->timeout) {
            Session::forget('lastActivityTime');
            $cookie = cookie('intend',
                $isLoggedIn ? url()->current() : 'admin');
            $email = $request->user()->email;
            UserExt::logout();

            return redirect()->route('login')->withInput(['email' => $email])
                ->withCookie($cookie);
        }
        $isLoggedIn ? Session::put('lastActivityTime', time())
            : Session::forget('lastActivityTime');

        return $next($request);
    }
}
