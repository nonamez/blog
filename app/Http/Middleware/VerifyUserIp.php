<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUserIp
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
        $allowed_ip = config('auth.allowed_ip');
        
        if (count($allowed_ip) > 0 && in_array($request->getClientIp(TRUE), $allowed_ip) == FALSE) {
            auth()->logout();
            
            return redirect('/auth/login')->withErrors(trans('errors.incorrect_login_ip'));
        }
            
        return $next($request);
    }
}
