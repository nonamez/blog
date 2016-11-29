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
		$posts = Models\Blog\TranslatedPost::orderBy('created_at', 'DESC')->paginate(20);
		
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
		
		// Helpers\Post::tags($request->get('tags', []), $translated_post);
		// Helpers\File::attach($request->get('files', []), $translated_post->id, 'post');
		
		return response()->json(['redirect_to' => route('admin.posts.edit', $post->id)]);
	}
	
	public function edit($post_id)
	{
		$post = Blog\TranslatedPost::find($post_id);
		
		$locales = config('app.locales');
		
		$data = [
			'post'    => $post,
			'locales' => array_combine($locales, $locales)
		];
		
		return view('admin.posts.edit', $data);
	}

	public function update(PostRequest $request, $post_id)
	{
		$translated_post = Blog\TranslatedPost::find($post_id);
		
		$data = $request->all();

		$translated_post->update($data);

		Helpers\Post::tags($request->get('tags', []), $translated_post);
		Helpers\File::attach($request->get('files', []), $translated_post->id, 'post');

		// Parent post update if exists
		if ($data['parent_post'] != $translated_post->post_id) {
			if (is_null(Blog\Post::find($data['parent_post'])))
				return redirect()->back()->withInput()->withErrors('Parent post not found');

			$translated_post->post_id = $data['parent_post'];

			$translated_post->save();
		}

		return redirect()->back()->with('success', 'Post updated seccessfully');
	}

	public function delete($post_id, $all = FALSE)
	{
		$post = Models\Blog\TranslatedPost::find($post_id);
		
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

		return $translated_post;
		
		// Helpers\Post::tags($request->get('tags', []), $translated_post);
		// Helpers\File::attach($request->get('files', []), $translated_post->id, 'post');
		
		return response()->json(['redirect_to' => route('admin.posts.edit', $post->id)]);
	}
}