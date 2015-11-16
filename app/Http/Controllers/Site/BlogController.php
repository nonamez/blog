<?php

namespace App\Http\Controllers\Site;

use App\Models\Blog;
use App\Http\Controllers\Controller;

use App;
use Auth;
use Lang;
use View;
use Cache;
use Config;

class BlogController extends Controller 
{
	function __construct() 
	{
		$name = 'tags_in_header_' . App::getLocale();

		$tags = Cache::rememberForever($name, function() {
			$tags = Blog\Tag::whereHas('translated_posts', function($query) {
				$query->where('locale', '=', App::getLocale());
				$query->where('status', '=', 'published');
			})->ordered()->take(Config::get('blog.tags_in_header'))->get();

			return $tags;
		});
		
		View::share('tags', $tags);
	}

	public function posts()
	{
		$posts = Blog\Post::whereHas('translated', function($query) {
			$query->where('locale', '=', App::getLocale());
			// Show draft posts for admins
			if (Auth::guest())
				$query->where('status', '=', 'published');
		})->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(Config::get('blog.posts_per_page'));

		return View::make('blog.posts')->with('posts', $paginated);
	}

	public function post($slug)
	{
		$post = Blog\TranslatedPost::with(['parent', 'tags']);
		
		$post->where('slug', '=', $slug);
		
		// Show draft posts for admins
		if (Auth::guest())
			$post->where('status', '=', 'published');
		
		$post = $post->firstOrFail();

		return View::make('blog/post', [
			'post'             => $post,
			'meta_keywords'    => $post->meta_keywords,
			'meta_description' => $post->meta_description,
		]);
	}
	
	public function postsByTag($tag)
	{
		$tag = Blog\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->where('locale', '=', App::getLocale())->where('status', '=', 'published')->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(Config::get('blog.posts_per_page'));
		
		return View::make('blog/posts')->with('posts', $paginated);
	}
}
