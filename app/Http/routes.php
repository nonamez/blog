<?php
/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

// Redirect from / to lang
Route::get('', function() {
	if (in_array(Request::segment(1), config('app.locales')))
		return redirect()->to(Request::segment(1));
	elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		return redirect()->to(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		return redirect()->to(config('app.fallback_locale'));
});

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

Route::get('file/{date}/{name}', ['as' => 'file_get', 'uses' => 'Admin\FileController@get']);

/*
|--------------------------------------------------------------------------
| Fron-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/{locale}', 'Blog\PostController@posts')->where('locale', implode('|', Config::get('app.locales')));

// Blog
Route::group(['prefix' => app()->getLocale()], function() {
	Route::get('post/{slug}', ['as' => 'post', 'uses' => 'Blog\PostController@post']);
	Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'Blog\PostController@postsByTag']);
	
	Route::get('about', ['as' => 'about', function() {
		return view()->make('about');
	}]);
});

// Portfolio
Route::group(['prefix' => 'portfolio'], function() {
	Route::get('', ['as' => 'portfolio', 'middleware' => 'check_portfolio', 'uses' => 'Portfolio\WorkController@index']);

	Route::get('authorize', ['as' => 'portfolio_show_authorize', 'uses' => 'Portfolio\AuthorizeController@index']);
	Route::post('authorize', ['as' => 'portfolio_authorize', 'uses' => 'Portfolio\AuthorizeController@authorizePortfolio']);
});

// Helpers for posts examples
Route::get('sleep/{time}', function($time) {
	sleep(intval($time));

	return response()->json(['quote' => Inspiring::quote()]);
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('auth/login', ['as' => 'auth_get', 'uses' => 'AuthController@getLogin']);
Route::post('auth/login', ['as' => 'auth_post', 'uses' => 'AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['check_ip', 'auth', 'check_id'], 'prefix' => 'admin'], function() {
	Route::get('', ['as' => 'admin_posts', 'uses' => 'Admin\PostController@index']);
	
	// Posts
	Route::get('post/create', ['as' => 'admin_post_create', 'uses' => 'Admin\PostController@create']);
	Route::post('post/create', ['as' => 'admin_post_store', 'uses' => 'Admin\PostController@store']);
	Route::get('post/edit/{post_id}', ['as' => 'admin_post_edit', 'uses' => 'Admin\PostController@edit']);
	Route::post('post/edit/{post_id}',['as' => 'admin_post_update', 'uses' => 'Admin\PostController@update']);
	Route::get('post/delete/{post_id}/{all?}', ['as' => 'admin_post_delete', 'uses' => 'Admin\PostController@delete']);
	
	// Files
	Route::get('files', ['as' => 'admin_files', 'uses' => 'Admin\FileController@index']);
	Route::post('file/upload', ['as' => 'admin_file_store', 'uses' => 'Admin\FileController@store']);
	Route::post('file/update/{file_id}', ['as' => 'admin_file_update', 'uses' => 'Admin\FileController@update']);
	Route::get('file/delete/{file_id}', ['as' => 'admin_file_delete', 'uses' => 'Admin\FileController@delete']);

	// Portfolio
	Route::group(['prefix' => 'portfolio'], function() {
		Route::get('', function() {
			return redirect()->route('admin_portfolio_works');
		});

		Route::get('works', ['as' => 'admin_portfolio_works', 'uses' => 'Admin\Portfolio\WorkController@index']);
		
		Route::get('work/create', ['as' => 'admin_portfolio_create_work', 'uses' => 'Admin\Portfolio\WorkController@work']);
		Route::get('work/edit/{work_id}', ['as' => 'admin_portfolio_edit_work', 'uses' => 'Admin\Portfolio\WorkController@work']);

		Route::post('work/store', ['as' => 'admin_portfolio_store_work', 'uses' => 'Admin\Portfolio\WorkController@store']);
		Route::post('work/update/{work_id}', ['as' => 'admin_portfolio_update_work', 'uses' => 'Admin\Portfolio\WorkController@update']);
		Route::get('work/delete/{work_id}', ['as' => 'admin_portfolio_delete_work', 'uses' => 'Admin\Portfolio\WorkController@delete']);

		Route::get('codes', ['as' => 'admin_portfolio_codes', 'uses' => 'Admin\Portfolio\CodeController@codes']);
		Route::post('codes/create', ['as' => 'admin_portfolio_create_code', 'uses' => 'Admin\Portfolio\CodeController@createCode']);
		Route::get('codes/delete/{id}', ['as' => 'admin_portfolio_delete_code', 'uses' => 'Admin\Portfolio\CodeController@deleteCode']);
	});
});