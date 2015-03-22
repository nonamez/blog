<?php namespace Site;

use Blog\Models\Post;
use Blog\Models\Tag;
use Blog\Models\TranslatedPost;

use Lang;
use View;
use Config;

/*
	ToDo:
		* Rewrite tags ordering
*/

class BlogController extends \BaseController {

	function __construct() 
	{
		$tags = Tag::whereHas('translated_posts', function($query) {
			$query->where('locale', '=', app()->getLocale());
			$query->where('status', '=', 'published');
		})->ordered()->take(Config::get('blog.tags_in_header'))->get();
		
		View::share('tags', $tags);
	}

	public function posts()
	{
		$posts = Post::whereHas('translated', function($query) {
			$query->where('locale', '=', app()->getLocale());
			$query->where('status', '=', 'published');
		})->orderBy('id', 'DEC');
		
		$paginated = $posts->paginate(Config::get('blog.posts_per_page'));

		return View::make('blog.posts')->with('posts', $paginated);
	}

	public function post($slug)
	{
		$post = TranslatedPost::with(array('parent', 'tags'))->where('slug', '=', $slug)->firstOrFail();
		
		return View::make('blog/post', array(
			'post'             => $post,
			'meta_keywords'    => $post->meta_keywords,
			'meta_description' => $post->meta_description,
		));
	}
	
	public function postsByTag($tag)
	{
		$tag = Tag::where('slug', '=', $tag)->firstOrFail();
		
		$posts = $tag->translated_posts()->where('locale', '=', app()->getLocale())->where('status', '=', 'published');
		
		$paginated = $posts->paginate(Config::get('blog.posts_per_page'));
		
		return View::make('blog/posts')->with('posts', $paginated);
	}
}
