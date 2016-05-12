<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\File as FileModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;

use App\Helpers\Admin as Helpers;

use DB;

class PostController extends Controller
{
	public function index()
	{
		$paginated = Blog\TranslatedPost::orderBy('created_at', 'DESC')->paginate(20);
		
		return view('admin.post.index')->with('posts', $paginated);
	}

	public function create()
	{
		$locales = config('app.locales');

		$data = [
			'tags'    => request()->old('tags'),
			// Select files that was uploaded today, but not yet assigned to the post
			'files'   => FileModel::whereType('post')->where('parent_id', '=', NULL)->where(DB::raw('DATE(`created_at`)'), '=', date('Y-m-d'))->get(),
			'locales' => array_combine($locales, $locales)
		];
		
		return view('admin.post.create', $data);
	}

	public function store(PostRequest $request)
	{
		$data = $request->all();
		
		$translated_post = new Blog\TranslatedPost($data);
		
		// Select parent or create new
		if (is_numeric($data['parent_post']))
			$post = Blog\Post::find($data['parent_post']);
		else {
			$post = new Blog\Post;
			
			$post->save();
		}

		$post->translated()->save($translated_post);
		
		Helpers\Post::tags($request->get('tags', []), $translated_post);
		Helpers\File::attach($request->get('files', []), $translated_post->id, 'post');
		
		return redirect()->route('admin_posts');
	}
	
	public function edit($post_id)
	{
		$post = Blog\TranslatedPost::find($post_id);
		
		$locales = config('app.locales');
		
		$data = [
			'post'    => $post,
			'locales' => array_combine($locales, $locales)
		];
		
		return view('admin.post.edit', $data);
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
		
		return redirect()->back()->with('notice', sprintf($message, $title));
	}
}
