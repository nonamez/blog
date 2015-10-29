<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;

use DB;
use URL;
use View;
use Config;
use Request;
use Redirect;
use Validator;

class PostController extends Controller
{
	public function index()
	{
		$paginated = Blog\TranslatedPost::orderBy('created_at', 'DESC')->paginate(5);
		
		return View::make('admin.post.index')->with('posts', $paginated);
	}

	public function create()
	{
		$locales = Config::get('app.locales');

		$data = [
			'tags'    => Request::old('tags'),
			// Select files that was uploaded today, but not yet assigned to the post
			'files'   => Blog\File::where('post_id', '=', NULL)->where(DB::raw('DATE(`created_at`)'), '=', date('Y-m-d'))->get(),
			'locales' => array_combine($locales, $locales)
		];
		
		return View::make('admin.post.create', $data);
	}

	public function store(PostRequest $request)
	{
		$data = $request->all();
		
		$data['title'] = htmlspecialchars($data['title']);
		
		$translated_post = new Blog\TranslatedPost($data);
		
		// Select parent or create new
		if (is_numeric($data['parent_post']))
			$post = Blog\Post::find($data['parent_post']);
		else {
			$post = new Blog\Post;
			
			$post->save();
		}

		$post->translated()->save($translated_post);
		
		$this->_tags($request->get('tags', []), $translated_post);
		$this->_files($request->get('files', []), $translated_post->id);
		
		return Redirect::route('admin_posts');
	}
	
	public function edit($post_id)
	{
		$post = Blog\TranslatedPost::find($post_id);
		
		$locales = Config::get('app.locales');
		
		$data = [
			'post'    => $post,
			'locales' => array_combine($locales, $locales)
		];
		
		return View::make('admin.post.edit', $data);
	}

	public function update(PostRequest $request, $post_id)
	{
		$translated_post = Blog\TranslatedPost::find($post_id);
		
		$data = $request->all();

		$data['title'] = htmlspecialchars($data['title']);
		
		try {
			$translated_post->update($data);
		} catch (\Exception $exception) {
			if (strpos($exception->getMessage(), 'blg_translated_posts_post_id_locale_unique') !== FALSE)
				return Redirect::back()->withErrors('Locale already exists');
				
			if (strpos($exception->getMessage(), 'blg_translated_posts_slug_unique') !== FALSE)
				return Redirect::back()->withErrors('Slug already exists');
		}

		$this->_tags($request->get('tags', []), $translated_post);
		$this->_files($request->get('files', []), $translated_post->id);

		// Parent post update if exists
		if ($data['parent_post'] != $translated_post->post_id) {
			if (is_null(Blog\Post::find($data['parent_post'])))
				return Redirect::back()->withInput()->withErrors('Parent post not found');

			$translated_post->post_id = $data['parent_post'];

			$translated_post->save();
		}

		return Redirect::back()->with('success', 'Post updated seccessfully');
	}

	public function delete($post_id, $all = FALSE)
	{
		$post = Blog\TranslatedPost::find($post_id);
		
		$title = $post->title;
		
		if ($all) {
			foreach ($post->parent->translated as $translated_post) {
				foreach ($translated_post->files as $file)
					$file->delete();
				
				$post->parent->delete();
			}
			
			$message = 'The post "%s" and its translations successfully deleted';
		} else {
			foreach ($post->files as $file)
				$file->delete();
			
			$post->delete();
			
			$message = 'The post "%s" successfully deleted';
		}
		
		return Redirect::back()->with('notice', sprintf($message, $title));
	}

	// Attach tags to the post
	private function _tags(array $data, & $post)
	{
		$new_tags = [];

		if (array_key_exists('titles', $data) && array_key_exists('slugs', $data)) {
			foreach ($data['titles'] as $key => $name) {
				if (array_key_exists($key, $data['slugs']))
					$slug = strtolower($data['slugs'][$key]);
				else
					$slug = strtolower($name);
				
				$tag = Blog\Tag::firstOrCreate(['slug' => $slug, 'name' => $name]);
				
				array_push($new_tags, $tag->id);
			}
		}

		if (isset($data['ids']))
			$new_tags = array_merge($new_tags, $data['ids']);
		
		$post->tags()->sync($new_tags);
	}

	// Attach files to current post
	private function _files(array $files, $post_id)
	{
		if (count($files) > 0)
			Blog\File::whereIn('id', $files)->update(['post_id' => $post_id]);
	}
}
