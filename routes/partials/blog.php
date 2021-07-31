<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::pattern('locale', implode('|', config('blog.locales')));

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