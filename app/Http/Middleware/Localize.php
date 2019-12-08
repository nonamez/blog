<?php

namespace App\Http\Middleware;

use Closure;

use Carbon\Carbon;

class Localize
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
		$locales = config('app.locales');

		if (in_array($request->segment(1), $locales)) {
			$locale = $request->segment(1);
		} elseif (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), $locales)) {
			$locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		} else {
			$locale = config('app.fallback_locale');
		}
		
		app()->setLocale($locale);
		
		Carbon::setLocale($locale);

		return $next($request);
	}
}
