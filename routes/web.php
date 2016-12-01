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

Route::get('file/{date}/{name}', ['as' => 'file.get', 'uses' => 'Admin\Files\FileController@get']);

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
Route::group(['prefix' => 'portfolio', 'namespace' => 'Portfolio'], function() {
	Route::get('/', ['as' => 'portfolio.index', 'middleware' => 'portfolio.', 'uses' => 'WorkController@index']);

	Route::get('authenticate', ['as' => 'portfolio.authenticate.get', 'uses' => 'LoginController@index']);
	Route::post('authenticate', ['as' => 'portfolio.authenticate.post', 'uses' => 'LoginController@authorizePortfolio']);
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

	// Posts
	Route::group(['prefix' => 'posts', 'namespace' => 'Posts'], function() {
		Route::get('/', ['as' => 'admin.posts.index', 'uses' => 'PostController@index']);
		Route::get('create', ['as' => 'admin.posts.create', 'uses' => 'PostController@create']);
		Route::post('store', ['as' => 'admin.posts.store', 'uses' => 'PostController@store']);
		Route::get('{post_id}/edit', ['as' => 'admin.posts.edit', 'uses' => 'PostController@edit']);
		Route::post('{post_id}/edit',['as' => 'admin.posts.update', 'uses' => 'PostController@update']);
		Route::get('{post_id}/delete/{all?}', ['as' => 'admin.posts.delete', 'uses' => 'PostController@delete']);
	});

	// Files
	Route::group(['prefix' => 'files', 'namespace' => 'Files'], function() {
		Route::get('/', ['as' => 'admin.files.index', 'uses' => 'FileController@index']);
		Route::post('upload', ['as' => 'admin.files.store', 'uses' => 'FileController@store']);
		Route::post('{file_id}/update', ['as' => 'admin.files.update', 'uses' => 'FileController@update']);
		Route::get('{file_id}/delete', ['as' => 'admin.files.delete', 'uses' => 'FileController@delete']);
	});

	// Portfolio
	Route::group(['prefix' => 'portfolio', 'namespace' => 'Portfolio'], function() {
		Route::group(['prefix' => 'works'], function() {
		    Route::get('/', ['as' => 'admin.portfolio.works.index', 'uses' => 'WorkController@index']);
			Route::get('create', ['as' => 'admin.portfolio.works.create', 'uses' => 'WorkController@work']);
			Route::post('store', ['as' => 'admin.portfolio.works.store', 'uses' => 'WorkController@store']);
			Route::get('{work_id}/edit', ['as' => 'admin.portfolio.works.edit', 'uses' => 'WorkController@work']);
			Route::post('{work_id}/update', ['as' => 'admin.portfolio.works.update', 'uses' => 'WorkController@update']);
			Route::get('{work_id}/delete', ['as' => 'admin.portfolio.works.delete(oid)', 'uses' => 'WorkController@delete']);
		});

		Route::group(['prefix' => 'codes'], function() {
			Route::get('/', ['as' => 'admin.portfolio.codes.index', 'uses' => 'CodeController@index']);
			Route::post('store', ['as' => 'admin.portfolio.codes.store', 'uses' => 'CodeController@store']);
			Route::get('{code_id}/delete', ['as' => 'admin.portfolio.codes.delete', 'uses' => 'CodeController@delete']);
		});
	});
});