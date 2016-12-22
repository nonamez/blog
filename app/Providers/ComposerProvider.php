<?php

namespace App\Providers;

use View;

use App\Models;

use Illuminate\Support\ServiceProvider;

class ComposerProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer(['blog.*', 'about'], function($view) {
			$name = 'header_tags_' . app()->getLocale();

			$tags = cache()->rememberForever($name, function() {
				$tags = Models\Blog\Tag::whereHas('translated_posts', function($query) {
					$query->where('locale', '=', app()->getLocale());
					$query->where('status', '=', 'published');
				})->ordered()->take(config('blog.tags_in_header'))->get();

				return $tags;
			});

			$view->with('tags', $tags);
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
