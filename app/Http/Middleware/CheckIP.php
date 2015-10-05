<?php

namespace App\Http\Middleware;

use Lang;
use Closure;

class CheckIP
{
	public function handle($request, Closure $next)
	{
		$allowed_ip = config()->get('auth.allowed_ip');
		
		if (is_array($allowed_ip) && in_array($request->getClientIp(TRUE), $allowed_ip) == FALSE)
			return redirect()->route('auth')->withErrors(Lang::get('errors.incorrect_login_ip'));
			
		return $next($request);
	}
}
