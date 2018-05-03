<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Config;

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
        $status = Config::where('name', 'site_status')->pluck('value')->first();

        // dd($status);
        if ($status == 0) {
            return redirect()->route('close');
        }
        return $next($request);
    }
}
