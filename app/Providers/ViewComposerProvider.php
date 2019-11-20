<?php

namespace App\Providers;

use View;

use App\Models;

use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
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
					$query->whereIn('status', ['published', 'hidden']);
				})->ordered()->take(15)->get();

				return $tags;
			});

			$view->with('tags_global', $tags);

			mb_internal_encoding('UTF-8');

			$top_links = [
				[
					'segment' => NULL,
					'url'  => url(app()->getLocale()),
					'char' => mb_substr(trans('blog.header.menu.home'), 0, 1),
					'text' => mb_substr(trans('blog.header.menu.home'), 1),
				],

				[
					'segment' => 'about',
					'url'  => route('about', app()->getLocale()),
					'char' => mb_substr(trans('blog.header.menu.about'), 0, 1),
					'text' => mb_substr(trans('blog.header.menu.about'), 1),
				],

				[
					'segment' => 'contacts',
					'url'  => url('/'),
					'char' => mb_substr(trans('blog.header.menu.contacts'), 0, 1),
					'text' => mb_substr(trans('blog.header.menu.contacts'), 1),
				]
			];

			$view->with('top_links', $top_links);
			$view->with('top_links_segment', request()->segment(2));
		});

		// View::composer('admin.posts.*', function($view) {
		// 	$locales = config('app.locales');
		// 	$locales = array_combine($locales, $locales);

		// 	$view->with('locales', $locales);
		// });
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
