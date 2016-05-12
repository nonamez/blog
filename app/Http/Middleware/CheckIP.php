<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckIP
{
	public function handle($request, Closure $next)
	{
		$allowed_ip = config('auth.allowed_ip');
		
		if (count($allowed_ip) > 0 && in_array($request->getClientIp(TRUE), $allowed_ip) == FALSE) {
			Auth::logout();
			
			return redirect()->route('auth_get')->withErrors(trans('errors.incorrect_login_ip'));
		}
			
		return $next($request);
	}
}
