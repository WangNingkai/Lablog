<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class CheckPermission
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
        # 1)判断用户状态 2)判断用户权限
        if (Auth()->user()->status == User::FORBID)
        {
            Auth::logout();
            Tool::showMessage('您的帐号被管理员停用，请联系管理员',false);
            return redirect()->route('home');
        }
        $route = Route::currentRouteName();
        if ($permission = Permission::query()->where('route', $route)->first()) {
            if (! Auth::user()->can($permission->name)) {
                Tool::showMessage('权限不足',false);
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
