<?php
Route::get('/', function() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		return Redirect::to('/' . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		return Redirect::to('/' . Config::get('app.fallback_locale'));
});

$locale = App::getLocale();

/*
|--------------------------------------------------------------------------
| Fron-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/{locale}', 'Site\BlogController@posts')->where('locale', implode('|', Config::get('app.locales')));

Route::group(['prefix' => $locale], function() {
	Route::get('/post/{slug}', array('as' => 'post', 'uses' => 'Site\BlogController@post'));
	Route::get('/tag/{slug}', array('as' => 'tag', 'uses' => 'Site\BlogController@postsByTag'));
	
	Route::get('/about', array('as' => 'about', function() {
		return View::make('about');
	}));
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/auth', function() {
	return View::make('auth');
});

Route::post('/auth', array('as' => 'auth', 'uses' => 'UserController@authorize'));


/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth', 'prefix' => 'admin'), function() {
	Route::get('/', array('as' => 'posts', 'uses' => 'Admin\PostController@index'));
	
	// Posts
	Route::get('/posts/create', array('as' => 'post_create', 'uses' => 'Admin\PostController@create'));
	Route::post('/posts/create', array('as' => 'post_store', 'uses' => 'Admin\PostController@store'));
	Route::get('/posts/delete/{post_id}/{all?}', array('as' => 'post_delete', 'uses' => 'Admin\PostController@delete'));
});
