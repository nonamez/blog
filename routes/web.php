<?php
/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

// Redirect from / to lang
Route::get('/', function() {
	if (in_array(Request::segment(1), config('app.locales')))
		return redirect()->to(Request::segment(1));
	elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), Config::get('app.locales')))
		return redirect()->to(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	else
		return redirect()->to(config('app.fallback_locale'));
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

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

Route::get('/{locale}', 'Blog\PostController@index')->where('locale', implode('|', Config::get('app.locales')));

// Blog
Route::group(['prefix' => app()->getLocale()], function() {
	Route::get('post/{slug}', ['as' => 'posts.show', 'uses' => 'Blog\PostController@show']);
	Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'Blog\PostController@postsByTag']);
	
	Route::get('about', ['as' => 'about', function() {
		return view()->make('about');
	}]);
});

// Portfolio
Route::group(['prefix' => 'portfolio'], function() {
	Route::get('', ['as' => 'portfolio', 'middleware' => 'check_portfolio', 'uses' => 'Portfolio\WorkController@index']);

	Route::get('authenticate', ['as' => 'portfolio.authenticate.get', 'uses' => 'Portfolio\LoginController@index']);
	Route::post('authenticate', ['as' => 'portfolio.authenticate.post', 'uses' => 'Portfolio\LoginController@authorizePortfolio']);
});

// Helpers for posts examples
Route::get('sleep/{time}', function($time) {
	sleep(intval($time));

	return response()->json(['quote' => Illuminate\Foundation\Inspiring::quote()]);
});

/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['user_ip', 'auth'], 'prefix' => 'admin', 'namespace' => 'Admin'], function() {
	Route::get('/', function() {
		return redirect()->route('admin.posts.index');
	});

	Route::group(['prefix' => 'posts'], function() {
		Route::get('/', ['as' => 'admin.posts.index', 'uses' => 'PostController@index']);
		Route::get('create', ['as' => 'admin.posts.create', 'uses' => 'PostController@create']);
		Route::post('store', ['as' => 'admin.posts.store', 'uses' => 'PostController@store']);
		Route::get('{post_id}/edit', ['as' => 'admin.posts.edit', 'uses' => 'PostController@edit']);
		Route::post('{post_id}/edit',['as' => 'admin.posts.update', 'uses' => 'PostController@update']);
		Route::get('{post_id}/delete/{all?}', ['as' => 'admin.posts.delete', 'uses' => 'PostController@delete']);
	});

	Route::group(['prefix' => 'files'], function() {
		Route::get('/', ['as' => 'admin_files', 'uses' => 'FileController@index']);
		Route::post('upload', ['as' => 'admin_file_store', 'uses' => 'FileController@store']);
		Route::post('{file_id}/update', ['as' => 'admin_file_update', 'uses' => 'FileController@update']);
		Route::get('{file_id}/delete', ['as' => 'admin_file_delete', 'uses' => 'FileController@delete']);
	});

	// Portfolio
	Route::group(['prefix' => 'portfolio', 'namespace' => 'Portfolio'], function() {
		Route::get('', function() {
			return redirect()->route('admin_portfolio_works');
		});

		Route::get('works', ['as' => 'admin_portfolio_works', 'uses' => 'WorkController@index']);
		
		Route::get('work/create', ['as' => 'admin_portfolio_create_work', 'uses' => 'WorkController@work']);
		Route::get('work/edit/{work_id}', ['as' => 'admin_portfolio_edit_work', 'uses' => 'WorkController@work']);

		Route::post('work/store', ['as' => 'admin_portfolio_store_work', 'uses' => 'WorkController@store']);
		Route::post('work/update/{work_id}', ['as' => 'admin_portfolio_update_work', 'uses' => 'WorkController@update']);
		Route::get('work/delete/{work_id}', ['as' => 'admin_portfolio_delete_work', 'uses' => 'WorkController@delete']);

		Route::get('codes', ['as' => 'admin_portfolio_codes', 'uses' => 'CodeController@codes']);
		Route::post('codes/create', ['as' => 'admin_portfolio_create_code', 'uses' => 'CodeController@createCode']);
		Route::get('codes/delete/{id}', ['as' => 'admin_portfolio_delete_code', 'uses' => 'CodeController@deleteCode']);
	});
});