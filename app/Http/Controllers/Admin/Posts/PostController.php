<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;

use App\Helpers\Admin as Helpers;

class PostController extends Controller
{
	public function index()
	{
		$posts = Models\Blog\Post\Translated::orderBy('created_at', 'DESC')->paginate(20);
		
		return view('admin.posts.index', compact('posts'));
	}

	public function create()
	{
		$locales = config('app.locales');
		$locales = array_combine($locales, $locales);

		return view('admin.posts.create', compact('locales'));
	}

	public function store(PostRequest $request)
	{
		$post = $this->_save($request);
				
		return response()->json(['redirect_to' => route('admin.posts.edit', $post->id)]);
	}
	
	public function edit($post_id)
	{
		$post = Models\Blog\Post\Translated::findOrFail($post_id);
		
		$locales = config('app.locales');
		$locales = array_combine($locales, $locales);
		
		return view('admin.posts.edit', compact('locales', 'post'));
	}

	public function update(PostRequest $request, $post_id)
	{
		$post = Models\Blog\Post\Translated::findOrFail($post_id);

		$this->_save($request, $post);
		
		return response()->json();
	}

	public function delete($post_id, $all = FALSE)
	{
		$post = Models\Blog\Post\Translated::findOrFail($post_id);
		
		$title = $post->title;

		if ($all) {
			foreach ($post->parent->translated as $translated_post) {
				foreach ($translated_post->files as $file) {
					$file->delete();
				}
				
				$post->parent->delete();
			}
			
			$message = 'The post "%s" and its translations successfully deleted';
		} else {
			foreach ($post->files as $file) {
				$file->delete();
			}
			
			$post->delete();
			
			$message = 'The post "%s" successfully deleted';
		}
		
		return redirect()->back()->with('notice', sprintf($message, $title));
	}

	private function _save(& $request, & $translated_post = FALSE)
	{
		if ($translated_post == FALSE) {
			$translated_post = new Models\Blog\Post\Translated;
		}

		$translated_post->fill($request->all());

		// Select parent or create new
		$parent_post = Models\Blog\Post\Post::findOrNew($request->parent_post);

		if (is_null($parent_post->id)) {
			$parent_post->save();
		}
		
		$parent_post->translated()->save($translated_post);

		// ========================= Tags ========================= //

		$tags = [];

		foreach ($request->get('tags', []) as $tag) {
			if (strlen($tag['slug']) == 0) {
				$tag['slug'] = strtolower(str_replace(' ', '_', $tag['name']));
			}

			$tag = Models\Blog\Tag::firstOrCreate($tag);

			array_push($tags, $tag->id);
		}

		$translated_post->tags()->sync($tags);

		// Here we also could do "UPDATE" by ids for faster performance
		foreach ($request->get('files', []) as $file_id) {
			$file = Models\File::findOrFail($file_id);

			$translated_post->files()->save($file);
		}

		return $translated_post;
	}
}