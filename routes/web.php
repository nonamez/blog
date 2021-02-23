<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers;

Route::pattern('locale', implode('|', config('blog.locales')));

/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

// Redirect from / to lang
Route::get('/', function() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), config('blog.locales'))) {
		return redirect()->to(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	} else {
		return redirect()->to(config('app.fallback_locale'));
	}
});

require __DIR__ . '/auth.php';

// Blog
Route::prefix('{locale}')->middleware('localize')->group(function() {
	Route::get('/', [Controllers\Blog\Posts\PostController::class, 'index'])->name('blog.posts.index');

	Route::get('post/{slug}', [Controllers\Blog\Posts\PostController::class, 'show'])->name('blog.posts.show');
	Route::get('tag/{slug}', 'Blog\Posts\PostController@postsByTag')->name('blog.posts.tag');
	
	Route::view('about', 'blog.about')->name('blog.about');
});

Route::middleware([/*'user_ip', 'auth'*/])->prefix('dashboard')->namespace('Dashboard')->group(function() {
	Route::view('/', 'dashboard.index')->name('dashboard.index');

	// Posts
	Route::group(['prefix' => 'posts', 'namespace' => 'Posts'], function() {
		Route::get('/', 'PostController@index')->name('dashboard.posts.index');
		Route::post('save/{translated_post?}', 'PostController@save')->name('dashboard.posts.save');
		Route::get('{translated_post}/find', 'PostController@find')->name('dashboard.posts.find');
		Route::post('{translated_post}/delete/{all?}', 'PostController@delete')->name('dashboard.posts.delete');
	});

	// Files
	Route::group(['prefix' => 'files', 'namespace' => 'Files'], function() {
		Route::get('/', ['as' => 'dashboard.files.index', 'uses' => 'FileController@index']);
		Route::post('upload', 'FileController@store')->name('dashboard.files.store');
		Route::post('{file_id}/update', 'FileController@update')->name('dashboard.files.update');
		Route::post('{file_id}/delete', 'FileController@delete')->name('dashboard.files.delete');
	});
});

// // Helpers for posts examples
// Route::get('sleep/{time}', function($time) {
// 	sleep(intval($time));

// 	return response()->json(['quote' => Illuminate\Foundation\Inspiring::quote()]);
// });

// Route::view('/about', 'blog.about')->name('blog.about');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
