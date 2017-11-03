<?php
/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

// Redirect from / to lang
Route::get('/', function() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), config('app.locales'))) {
		return redirect()->to(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	} else {
		return redirect()->to(config('app.fallback_locale'));
	}
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

Route::get('storage/{date}/{name}')->name('storage.file');

/*
|--------------------------------------------------------------------------
| Site map
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', ['as' => 'sitemap.index', 'uses' => 'SiteMapController@index']);
Route::get('/sitemap-posts-{locale}.xml', ['as' => 'sitemap.posts', 'uses' => 'SiteMapController@posts']);

/*
|--------------------------------------------------------------------------
| Fron-end Routes
|--------------------------------------------------------------------------
*/

Route::get('/{locale}', ['as' => 'blog.locale', 'uses' => 'Blog\PostController@index'])->where('locale', implode('|', config('app.locales')));

// Blog
Route::group(['prefix' => app()->getLocale()], function() {
	Route::get('post/{slug}', ['as' => 'posts.show', 'uses' => 'Blog\PostController@show']);
	Route::get('tag/{slug}', ['as' => 'tag', 'uses' => 'Blog\PostController@postsByTag']);
	
	Route::get('about', ['as' => 'about', function() {
		return view('about');
	}]);
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
		Route::post('{post_id}/update',['as' => 'admin.posts.update', 'uses' => 'PostController@update']);
		Route::get('{post_id}/delete/{all?}', ['as' => 'admin.posts.delete', 'uses' => 'PostController@delete']);
	});

	// Files
	Route::group(['prefix' => 'files', 'namespace' => 'Files'], function() {
		Route::get('/', ['as' => 'admin.files.index', 'uses' => 'FileController@index']);
		Route::post('upload', ['as' => 'admin.files.store', 'uses' => 'FileController@store']);
		Route::post('{file_id}/update', ['as' => 'admin.files.update', 'uses' => 'FileController@update']);
		Route::get('{file_id}/delete', ['as' => 'admin.files.delete', 'uses' => 'FileController@delete']);
	});
});