<?php

namespace App\Http\Controllers\Dashboard\Posts;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
	public function index()
	{
		$posts = Models\Blog\Post\Translated::orderBy('date', 'DESC')->paginate(20);

		return response()->json(compact('posts'));
	}

	public function find(Models\Blog\Post\Translated $translated_post)
	{
		$translated_post->load('tags', 'files');

		return response()->json(['post' => $translated_post]);
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
		
		return response()->json(['message' => sprintf($message, $title)]);
	}

	public function save(Request $request, Models\Blog\Post\Translated $translated_post = NULL)
	{
		$rules = [
			'date'    => 'date_format:Y-m-d H:i:s',
			'slug'    => ['min:3', 'nullable'],
			'title'   => ['required', 'min:5'],
			'locale'  => ['required', 'in:' . implode(',', config('app.locales'))],
			'status'  => ['required', 'in:draft,published,hidden'],
			'content' => ['required', 'min:10'],
			'tags'    => ['array', 'min:1'],
			'files'   => 'array',
			'markdown' => ['required', 'boolean'],
			'parent_id' => 'exists:blg_posts,id'
		];

		if ($translated_post) {
			$rules['slug'] = 'unique:blg_translated_posts,slug,' . $translated_post->id;
		} else {
			$rules['slug'] = 'unique:blg_translated_posts,slug';
		}

		$request->validate($rules);

		$slug = $request->get('slug', $request->get('title'));
		$slug = Str::slug($slug);

		// Check if new slug exists
		$translated_post_by_slug = Models\Blog\Post\Translated::where('slug', $slug)->select('id')->first();

		// If slugs exists && (post is new or current slug exists in orther post)
		if ($translated_post_by_slug && (($translated_post == NULL) || ($translated_post_by_slug->id != $translated_post->id))) {
			return response()->json(['errors' => ['slug' => 'The slug has already been taken.']], 422);
		}

		unset($translated_post_by_slug);

		if ($translated_post == NULL) {
			$translated_post = new Models\Blog\Post\Translated;
		}

		$translated_post->fill($request->only((new Models\Blog\Post\Translated)->getFillable()));

		$translated_post->slug = $slug;

		// Select parent or create new
		$parent_post = Models\Blog\Post\Post::findOrNew($request->get('parent_id'));

		if ($parent_post->exists == FALSE) {
			$parent_post->save();
		}

		$parent_post->translated()->save($translated_post);

		// ========================= Tags ========================= //

		$tags = [];

		foreach ($request->get('tags', []) as $tag) {
			if (strlen($tag['slug']) == 0) {
				$tag['slug'] = $tag['name'];
			}

			$tag['slug'] = Str::slug($tag['slug']);

			$tag = Models\Blog\Tag::firstOrCreate([
				'slug' => $tag['slug']
			], [
				'name' => $tag['name']
			]);

			$tags[] = $tag->id;
		}

		$translated_post->tags()->sync($tags);

		// ========================= Files ========================= //

		// Here we also could do "UPDATE" by ids for faster performance
		DB::table((new Models\File)->getTable())->whereIn('id', $request->get('files'))->update([
			'fileable_id' => $translated_post->id,
			'fileable_type' => 'posts'
		]);

		$translated_post->load('files', 'tags');

		return response()->json(['post' => $translated_post]);
	}
}