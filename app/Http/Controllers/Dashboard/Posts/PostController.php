<?php

namespace App\Http\Controllers\Dashboard\Posts;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

	public function delete(Models\Blog\Post\Translated $translated_post, $all = FALSE)
	{	
		$title = $translated_post->title;

		if ($all) {
			foreach ($translated_post->parent->translated as $t) {
				foreach ($t->files as $file) {
					$file->delete();
				}
			}

			$t->parent->delete();
			
			$message = 'The post "%s" and its translations successfully deleted';
		} else {
			foreach ($translated_post->files as $file) {
				$file->delete();
			}
			
			$translated_post->delete();
			
			$message = 'The post "%s" successfully deleted';
		}
		
		return response()->json(['message' => sprintf($message, $title)]);
	}

	public function save(Request $request, Models\Blog\Post\Translated $translated_post = NULL)
	{
		$inputs = $request->all();

		$inputs['slug'] = Str::slug($inputs['slug']);

		$rules = [
			'date'    => 'date_format:Y-m-d H:i:s',
			'slug'    => ['min:3', 'required', 'unique:blg_translated_posts,slug,' . optional($translated_post)->id],
			'title'   => ['required', 'min:5'],
			'locale'  => ['required', 'in:' . implode(',', config('app.locales'))],
			'status'  => ['required', 'in:draft,published,hidden'],
			'content' => ['required', 'min:10'],
			'tags'    => 'array',
			'files'   => 'array',
			'markdown' => ['required', 'boolean'],
			'parent_id' => ['nullable', 'exists:blg_posts,id']
		];

		Validator::make($inputs, $rules)->validate();

		if ($translated_post == NULL) {
			$translated_post = new Models\Blog\Post\Translated;
		}

		$translated_post->fill($inputs);

		// Select parent or create new
		$parent_post = Models\Blog\Post\Post::findOrNew($inputs['parent_id']);

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