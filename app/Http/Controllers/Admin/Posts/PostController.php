<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Admin as Helpers;

class PostController extends Controller
{
	public function index()
	{
		$posts = Models\Blog\Post\Translated::orderBy('date', 'DESC')->paginate(20);
		
		return view('admin.posts.index', compact('posts'));
	}

	public function create()
	{
		return view('admin.posts.post', ['post' => FALSE]);
	}

	public function store(Requests\Admin\Post $request)
	{
		return $this->processPostData($request);
	}
	
	public function edit($post_id)
	{
		$post = Models\Blog\Post\Translated::with('tags', 'files')->findOrFail($post_id);

		return view('admin.posts.post', ['post' => $post]);
	}

	public function update(Requests\Admin\Post $request, $post_id)
	{
		$post = Models\Blog\Post\Translated::findOrFail($post_id);

		return $this->processPostData($request, $post);
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
		
		return redirect()->back()->with('message', 'success|' . sprintf($message, $title));
	}

	private function processPostData($request, $translated_post = FALSE)
	{
		$slug = $request->get('slug');

		if (is_null($slug)) {
			$slug = $request->get('title');
		}

		$slug = saniteziSlug($slug);

		// Check if new slug exists
		$translated_post_by_slug = Models\Blog\Post\Translated::where('slug', $slug)->first();

		// If slugs exists && (post is new or current slug exists in orther post)
		if ($translated_post_by_slug && (($translated_post == FALSE) || ($translated_post_by_slug->id != $translated_post->id))) {
			return response()->json(['errors' => ['slug' => 'The slug has already been taken.']], 422);
		}

		unset($translated_post_by_slug);

		if ($translated_post == FALSE) {
			$translated_post = new Models\Blog\Post\Translated;

			$translated_post->date = date('Y-m-d H:i:s');
		}

		$translated_post->fill($request->only((new Models\Blog\Post\Translated)->getFillable()));

		$translated_post->slug = $slug;

		// Select parent or create new
		$parent_post = Models\Blog\Post\Post::findOrNew($request->parent_post_id);

		if (is_null($parent_post->id)) {
			$parent_post->save();
		}
		
		$parent_post->translated()->save($translated_post);

		// ========================= Tags ========================= //

		$tags = [];

		foreach ($request->get('tags', []) as $tag) {
			if (strlen($tag['slug']) == 0) {
				$tag['slug'] = $tag['name'];
			}

			$tag['slug'] = saniteziSlug($tag['slug']);

			$tag = Models\Blog\Tag::firstOrCreate(['slug' => $tag['slug']], ['name' => $tag['name']]);

			array_push($tags, $tag->id);
		}

		$translated_post->tags()->sync($tags);

		// ========================= Files ========================= //

		// Here we also could do "UPDATE" by ids for faster performance
		foreach ($request->get('files', []) as $file) {
			$file = Models\File::findOrFail($file['id']);

			$translated_post->files()->save($file);
		}

		$translated_post->load('files', 'tags');

		return response()->json(['post' => $translated_post]);

	}
}