<?php

namespace App\Http\Controllers\Blog;

use App\Models;
use App\Http\Controllers\Controller;

class PostController extends Controller 
{
	public function index()
	{
		$posts = Models\Blog\Post\Translated::permitted()->where('locale', '=', app()->getLocale())->orderBy('id', 'DEC')->paginate(config('blog.posts_per_page')); 

		return view('blog.posts', compact('posts'));
	}

	public function show($slug)
	{
		$post = Models\Blog\Post\Translated::permitted()->with(['parent', 'tags'])->where('slug', '=', $slug)->firstOrFail();

		return view('blog.post', compact('post'));
	}
	
	public function postsByTag($tag)
	{
		$tag = Models\Blog\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->permitted()->where('locale', '=', app()->getLocale())->orderBy('id', 'DEC')->paginate(config('blog.posts_per_page'));
				
		return view('blog.posts', compact('posts'));
	}
}

