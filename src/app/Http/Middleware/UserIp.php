<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowed_ip = config('dashboard.allowed_ip');

        if (count($allowed_ip) > 0 && in_array($request->getClientIp(TRUE), $allowed_ip) == FALSE) {
            auth()->logout();
            
            return redirect('login')->with('error|' . trans('errors.incorrect_login_ip'));
        }
            
        return $next($request);
    }
}
