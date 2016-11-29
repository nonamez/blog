<?php

namespace App\Http\Controllers\Blog;

use App\Models;
use App\Http\Controllers\Controller;

use Auth;
use Cache;

class PostController extends Controller 
{
	function __construct() 
	{
		$name = 'tags_in_header_' . app()->getLocale();

		$tags = Cache::rememberForever($name, function() {
			$tags = Models\Blog\Tag::whereHas('translated_posts', function($query) {
				$query->where('locale', '=', app()->getLocale());
				$query->where('status', '=', 'published');
			})->ordered()->take(config('blog.tags_in_header'))->get();

			return $tags;
		});
		
		view()->share('tags', $tags);
	}

	public function index()
	{
		$posts = Models\Blog\Post\Translated::where('locale', '=', app()->getLocale())->orderBy('id', 'DEC'); 

		if (auth()->guest()) {
			$posts->where('status', '=', 'published');
		}
		
		$posts = $posts->paginate(config('blog.posts_per_page'));

		return view('blog.posts', compact('posts'));
	}

	public function show($slug)
	{
		$post = Models\Blog\Post\Translated::with(['parent', 'tags']);
		
		$post->where('slug', '=', $slug);
		
		// Hide draft posts for users
		if (auth()->guest()) {
			$post->where('status', '<>', 'draft');
		}
		
		$post = $post->firstOrFail();

		return view('blog/post', [
			'post'             => $post,
			'meta_keywords'    => $post->meta_keywords,
			'meta_description' => $post->meta_description,
		]);
	}
	
	public function postsByTag($tag)
	{
		$tag = Models\Blog\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->where('locale', '=', app()->getLocale())->where('status', '=', 'published')->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(config('blog.posts_per_page'));
		
		return view('blog/posts')->with('posts', $paginated);
	}
}

