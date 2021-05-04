<?php

namespace App\Http\Controllers\Blog\Posts;

use Illuminate\Http\Request;

use App\Models;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
	{
		$posts = Models\Blog\Posts\Translated::permitted()->where('locale', '=', app()->getLocale())->orderBy('date', 'DESC')->simplePaginate(10);

		return view('blog.posts.index', compact('posts'));
	}

	public function show($locale, $slug)
	{
		$post = Models\Blog\Posts\Translated::permitted()->with(['parent', 'tags'])->where('slug', '=', $slug)->firstOrFail();

		return view('blog.posts.show', compact('post'));
	}

	public function postsByTag($locale, $tag)
	{
		$tag = Models\Blog\Tags\Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->posts()->permitted()->where('locale', '=', $locale)->orderBy('date', 'DESC')->paginate(10);
				
		return view('blog.posts.index', compact('posts'));
	}
}
