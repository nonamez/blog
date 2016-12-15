<?php

namespace App\Http\Controllers\Blog;

use App\Models;
use App\Http\Controllers\Controller;

class PostController extends Controller 
{
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

		return view('blog.post', compact('post'));
	}
	
	public function postsByTag($tag)
	{
		$tag = Models\Blog\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->where('locale', '=', app()->getLocale())->where('status', '=', 'published')->orderBy('id', 'DEC');
		
		$posts = $posts->paginate(config('blog.posts_per_page'));
		
		return view('blog.posts', compact('posts'));
	}
}

