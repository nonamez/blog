<?php

/*
|--------------------------------------------------------------------------------
| Application Locale
|--------------------------------------------------------------------------------
|
| The following code determinates which locale is used in app for current request
| except the admin panel
|
*/

if (Request::segment(1) !== 'admin') {
	if (in_array(Request::segment(1), Config::get('app.locales')))
		App::setLocale(Request::segment(1));
	else
		return Redirect::to('/' . Config::get('app.fallback_locale'));
}
/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	// Share the locale key in to the view
	View::share('locale', App::getLocale());
});


App::after(function($request, $response)
{

});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) {
		if (Request::ajax())
			return Response::make('Unauthorized', 401);
		else
			return Redirect::route('auth');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
