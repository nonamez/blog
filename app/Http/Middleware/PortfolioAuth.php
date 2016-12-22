<?php

namespace App\Http\Middleware;

use Closure;

class PortfolioAuth
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
        if ($time = $request->session()->get('portfolio')) {
            if (86400 >= (time() - $time)) {
                return $next($request);
            }
        }

        $request->session()->forget('portfolio');

        return redirect()->route('portfolio.authenticate.get');
    }
}
