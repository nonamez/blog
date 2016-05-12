<?php

namespace App\Http\Middleware;

use Closure;

class PortfolioCheck
{
	public function handle($request, Closure $next)
	{
		if ($time = $request->session()->get('portfolio')) {
			if (86400 >= (time() - $time))
				return $next($request);
		}

		$request->session()->forget('portfolio');

		return redirect()->route('portfolio_show_authorize');
	}
}
