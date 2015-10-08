<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App;
use View;
use Config;
use Request;

use Carbon\Carbon;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		// Detect locale before routes
		if (App::runningInConsole() == FALSE) {
			if (in_array(Request::segment(1), Config::get('app.locales')))
				App::setLocale(Request::segment(1));
			elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
				App::setLocale(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
			else
				App::setLocale(Config::get('app.fallback_locale'));
			
			Carbon::setLocale(App::getLocale());
		}

		parent::boot($router);
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function ($router) {
			require app_path('Http/routes.php');
		});
	}
}
