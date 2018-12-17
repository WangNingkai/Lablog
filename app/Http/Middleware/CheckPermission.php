<?php

namespace App\Http\Middleware;

use App\Helpers\Extensions\UserExt;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Helpers\Extensions\Tool;

class CheckPermission
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
        if (!UserExt::currentUser()) {
            return redirect()->route('login');
        }
        # 1)判断用户状态 2)判断用户权限
        if (UserExt::getAttribute('status') == User::FORBID) {
            UserExt::logout();
            Tool::showMessage('您的帐号被管理员停用，请联系管理员', false);

            return redirect()->route('home');
        }
        $route = Route::currentRouteName();
        if ($permission = Permission::query()->where('route', $route)
            ->first()
        ) {
            if (!UserExt::hasPermissionTo($permission->name)) {
                Tool::showMessage('权限不足', false);

                return redirect()->back();
            }
        }

        return $next($request);
    }
}
