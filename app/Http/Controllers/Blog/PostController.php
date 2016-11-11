<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use App\Http\Controllers\Controller;

use Auth;
use Cache;

class PostController extends Controller 
{
	function __construct() 
	{
		$name = 'tags_in_header_' . app()->getLocale();

		$tags = Cache::rememberForever($name, function() {
			$tags = Blog\Tag::whereHas('translated_posts', function($query) {
				$query->where('locale', '=', app()->getLocale());
				$query->where('status', '=', 'published');
			})->ordered()->take(config('blog.tags_in_header'))->get();

			return $tags;
		});
		
		view()->share('tags', $tags);
	}

	public function posts()
	{
		$posts = Blog\Post::whereHas('translated', function($query) {
			$query->where('locale', '=', app()->getLocale());
			
			if (Auth::guest())
				$query->where('status', '=', 'published');

		})->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(config('blog.posts_per_page'));

		return view('blog.posts')->with('posts', $paginated);
	}

	public function post($slug)
	{
		$post = Blog\TranslatedPost::with(['parent', 'tags']);
		
		$post->where('slug', '=', $slug);
		
		// Hide draft posts for users
		if (Auth::guest())
			$post->where('status', '<>', 'draft');
		
		$post = $post->firstOrFail();

		return view('blog/post', [
			'post'             => $post,
			'meta_keywords'    => $post->meta_keywords,
			'meta_description' => $post->meta_description,
		]);
	}
	
	public function postsByTag($tag)
	{
		$tag = Blog\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->where('locale', '=', app()->getLocale())->where('status', '=', 'published')->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(config('blog.posts_per_page'));
		
		return view('blog/posts')->with('posts', $paginated);
	}
}

