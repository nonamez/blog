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
		$data = $request->all();
		
		$translated_post = new Models\Blog\TranslatedPost($data);
		
		// Select parent or create new
		if (is_numeric($data['parent_post'])){
			$post = Models\Blog\Post::find($data['parent_post']);
		} else {
			$post = new Models\Blog\Post;
			
			$post->save();
		}

		$post->translated()->save($translated_post);
		
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

	private function _save(& $request, & $document = FALSE)
	{
		if ($document == FALSE) {
			$document = new Models\Document\Document;

			$document->service_id = $request->service_id;
			$document->user_id    = auth()->id();
		}

		$data = $request->only('title', 'description', 'category_id');
		$data = array_map(function($value) {
			return strlen($value) == 0 ? NULL : $value;
		}, $data);

		$document->fill($data);

		$document->save();
}