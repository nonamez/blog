<?php

Route::get('/', function() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		return Redirect::to('/' . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		return Redirect::to('/' . Config::get('app.fallback_locale'));
});

$locale = App::getLocale();

Route::get('/{locale}', 'Site\BlogController@posts')->where('locale', implode('|', Config::get('app.locales')));

Route::group(['prefix' => $locale], function() {
	Route::get('/post/{slug}', array('as' => 'post', 'uses' => 'Site\BlogController@post'));
	Route::get('/tag/{slug}', array('as' => 'tag', 'uses' => 'Site\BlogController@postsByTag'));
	
	Route::get('/auth', function() {
		return View::make('auth');
	});
});
