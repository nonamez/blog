<?php
/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

// Redirect from / to lang
Route::get('/', function() {
	if (in_array(Request::segment(1), Config::get('app.locales')))
		return Redirect::to('/' . Request::segment(1));
	elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		return Redirect::to('/' . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		return Redirect::to('/' . Config::get('app.fallback_locale'));
});

// Set app lang
if (App::runningInConsole() == FALSE) {
	if (in_array(Request::segment(1), Config::get('app.locales')))
		App::setLocale(Request::segment(1));
	elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		App::setLocale(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		App::setLocale(Config::get('app.fallback_locale'));
}

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

Route::get('/file/{date}/{name}', array('as' => 'file_get', 'uses' => 'Admin\FileController@get'));

/*
|--------------------------------------------------------------------------
| Fron-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/{locale}', 'Site\BlogController@posts')->where('locale', implode('|', Config::get('app.locales')));

Route::group(array('prefix' => App::getLocale()), function() {
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

Route::get('/auth', 'AuthController@index');
Route::post('/auth', array('as' => 'auth', 'uses' => 'AuthController@authorize'));


/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth', 'prefix' => 'admin'), function() {
	Route::get('/', array('as' => 'posts', 'uses' => 'Admin\PostController@index'));
	
	// Posts
	Route::get('/post/create', array('as' => 'post_create', 'uses' => 'Admin\PostController@create'));
	Route::post('/post/create', array('as' => 'post_store', 'uses' => 'Admin\PostController@store'));
	Route::get('/post/edit/{post_id}', array('as' => 'post_edit', 'uses' => 'Admin\PostController@edit'));
	Route::post('/post/edit/{post_id}', array('as' => 'post_update', 'uses' => 'Admin\PostController@update'));
	Route::get('/post/delete/{post_id}/{all?}', array('as' => 'post_delete', 'uses' => 'Admin\PostController@delete'));
	
	// Files
	Route::post('/file/upload', array('as' => 'file_store', 'uses' => 'Admin\FileController@store'));
	Route::get('/file/delete/{file_id}', array('as' => 'file_delete', 'uses' => 'Admin\FileController@delete'));
});
