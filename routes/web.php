<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers;

Route::pattern('locale', implode('|', config('blog.locales')));

/*
|--------------------------------------------------------------------------
| Locale Detection
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

// Redirect from / to lang
Route::get('/', function() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && in_array(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), config('blog.locales'))) {
		return redirect()->to(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	} else {
		return redirect()->to(config('app.fallback_locale'));
	}
});

// Blog
Route::prefix('{locale}')->middleware('localize')->group(function() {
	Route::get('/', [Controllers\Blog\Posts\PostController::class, 'index'])->name('blog.posts.index');

	Route::get('post/{slug}', [Controllers\Blog\Posts\PostController::class, 'show'])->name('blog.posts.show');
	Route::get('tag/{slug}',  [Controllers\Blog\Posts\PostController::class, 'postsByTag'])->name('blog.posts.tag');
	
	Route::view('about', 'blog.about')->name('blog.about');
});

Route::middleware([/*'user_ip',*/ 'auth'])->prefix('dashboard')->group(function() {
	Route::view('/', 'dashboard.index')->name('dashboard.index');

	// Posts
	Route::prefix('posts')->group(function() {
		Route::get('/', [Controllers\Dashboard\Posts\PostController::class, 'index'])->name('dashboard.posts.index');
		
		Route::post('save/{translated_post?}', [Controllers\Dashboard\Posts\PostController::class, 'save'])->name('dashboard.posts.save');
		Route::get('{translated_post}/find', [Controllers\Dashboard\Posts\PostController::class, 'find'])->name('dashboard.posts.find');
		Route::post('{translated_post}/delete/{all?}', [Controllers\Dashboard\Posts\PostController::class, 'delete'])->name('dashboard.posts.delete');
	});

	// Files
	Route::prefix('files')->group(function() {
		Route::get('/', [Controllers\Dashboard\Files\FileController::class, 'index'])->name('dashboard.files.index');
		Route::post('upload', [Controllers\Dashboard\Files\FileController::class, 'store'])->name('dashboard.files.store');
		Route::post('{file_id}/update', 'FileController@update')->name('dashboard.files.update');
		Route::post('{file_id}/delete', [Controllers\Dashboard\Files\FileController::class, 'delete'])->name('dashboard.files.delete');
	});
});

Route::get('/auth', function() {
    $user = auth()->user();

	return new App\Http\Resources\Users\User($user);
})->middleware('auth');

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
