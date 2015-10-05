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

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

Route::get('/file/{date}/{name}', ['as' => 'file_get', 'uses' => 'Admin\FileController@get']);

/*
|--------------------------------------------------------------------------
| Fron-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/{locale}', 'Site\BlogController@posts')->where('locale', implode('|', Config::get('app.locales')));

Route::group(['prefix' => App::getLocale()], function() {
	Route::get('/post/{slug}', ['as' => 'post', 'uses' => 'Site\BlogController@post']);
	Route::get('/tag/{slug}', ['as' => 'tag', 'uses' => 'Site\BlogController@postsByTag']);
	
	Route::get('/about', ['as' => 'about', function() {
		return View::make('about');
	}]);
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/login', 'AuthController@getLogin');
Route::post('auth/login', ['as' => 'auth', 'uses' => 'AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['check_ip', 'auth', 'check_id'], 'prefix' => 'admin'], function() {
	Route::get('/', ['as' => 'admin_posts', 'uses' => 'Admin\PostController@index']);
	
	// Posts
	Route::get('/post/create', ['as' => 'admin_post_create', 'uses' => 'Admin\PostController@create']);
	Route::post('/post/create', ['as' => 'admin_post_store', 'uses' => 'Admin\PostController@store']);
	Route::get('/post/edit/{post_id}', ['as' => 'admin_post_edit', 'uses' => 'Admin\PostController@edit']);
	Route::post('/post/edit/{post_id}',['as' => 'admin_post_update', 'uses' => 'Admin\PostController@update']);
	Route::get('/post/delete/{post_id}/{all?}', ['as' => 'admin_post_delete', 'uses' => 'Admin\PostController@delete']);
	
	// Files
	Route::post('/file/upload', ['as' => 'admin_file_store', 'uses' => 'Admin\FileController@store']);
	Route::get('/file/delete/{file_id}', ['as' => 'admin_file_delete', 'uses' => 'Admin\FileController@delete']);
});
