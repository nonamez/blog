<?php

Route::pattern('locale', 'en|ru|lt');

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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

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
Route::group(['prefix' => '{locale}'], function() {
	Route::get('post/{slug}', ['as' => 'posts.show', 'uses' => 'Blog\PostController@show']);
	Route::get('tag/{slug}', 'Blog\PostController@postsByTag')->name('tag');
	
	Route::view('about', 'blog.about')->name('about');
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

Route::group(['middleware' => ['user_ip', 'auth'], 'prefix' => 'dashboard', 'namespace' => 'Dashboard'], function() {
	Route::view('/', 'dashboard.index')->name('dashboard.index');

	// Posts
	Route::group(['prefix' => 'posts', 'namespace' => 'Posts'], function() {
		Route::get('/', 'PostController@index')->name('dashboard.posts.index');
		Route::post('save/{post_id?}', 'PostController@save')->name('dashboard.posts.save');
		Route::get('{post_id}/find', 'PostController@find')->name('dashboard.posts.find');
		Route::get('{post_id}/delete/{all?}', 'PostController@delete')->name('dashboard.posts.delete');
	});

	// Files
	Route::group(['prefix' => 'files', 'namespace' => 'Files'], function() {
		Route::get('/', ['as' => 'dashboard.files.index', 'uses' => 'FileController@index']);
		Route::post('upload', 'FileController@store')->name('dashboard.files.store');
		Route::post('{file_id}/update', 'FileController@update')->name('dashboard.files.update');
		Route::post('{file_id}/delete', 'FileController@delete')->name('dashboard.files.delete');
	});
});