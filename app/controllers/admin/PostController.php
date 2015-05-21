<?php
namespace Admin;

use DB;
use URL;
use View;
use Input;
use Config;
use Redirect;
use Validator;

use Blog\Models\File;
use Blog\Models\Post;
use Blog\Models\Tag;
use Blog\Models\TranslatedPost;

class PostController extends \BaseController {

	private $_rules;

	function __construct()
	{
		$this->_rules = array(
			'slug'    => array('required', 'unique:blg_translated_posts'),
			'title'   => array('required', 'min:5'),
			'locale'  => array('required', 'in:' . implode(',', Config::get('app.locales'))),
			'status'  => array('required', 'in:draft,published'),
			'content' => array('required', 'min:10'),
			'tags'    => array('array','min:1'),
			'files'   => array('array','min:1'),
			'parent_post' => array('exists:blg_posts,id', 'integer')
		);
	}

	public function index()
	{
		$paginated = TranslatedPost::orderBy('created_at', 'DESC')->paginate(5);
		
		return View::make('admin.post.index')->with('posts', $paginated);
	}

	public function create()
	{
		$posts   = Post::orderBy('id', 'DESC')->take(5)->lists('id');
		$locales = Config::get('app.locales');
		
		$today = date('Y-m-d');
		
		$data = array(
			'tags'    => Input::old('tags'),
			// Selecting files that was uploaded today, but not yet assignet to the post
			'files'   => File::where('post_id', '=', NULL)->where(DB::raw('DATE(`created_at`)'), '=', $today)->get(),
			'posts'   => array_combine($posts, $posts),
			'locales' => array_combine($locales, $locales)
		);
		
		return View::make('admin.post.create', $data);
	}

	public function store()
	{
		$data = Input::only('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'files', 'tags', 'parent_post');
		
		$validator = Validator::make($data, $this->_rules);

		if ($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);
		
		$data['title'] = htmlspecialchars($data['title']);
		
		$translated_post = new TranslatedPost($data);
		
		// Select parent or create new
		if (is_numeric($data['parent_post'])) {
			$post = Post::find($data['parent_post']);
		} else {
			$post = new Post;
			
			$post->save();
		}

		$post->translated()->save($translated_post);
		
		$this->_tags($data['tags'], $translated_post);
		$this->_files($data['files'], $translated_post->id);
		
		return Redirect::to('/admin');
	}
	
	public function edit($post_id)
	{
		$post = TranslatedPost::find($post_id);
		
		if (is_null($post))
			return Redirect::back()->withErrors('Post not found');
		
		$locales = Config::get('app.locales');
		
		$data = array(
			'post'    => $post,
			'locales' => array_combine($locales, $locales)
		);
		
		return View::make('admin.post.edit', $data);
	}

	public function update($post_id)
	{
		$post = TranslatedPost::find($post_id);
		
		if (is_null($post))
			return Redirect::back()->withErrors('Post not found');

		$data = Input::only('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'files', 'tags', 'parent_post');

		$this->_rules['slug'] = 'required';
		
		$validator = Validator::make($data, $this->_rules);

		if ($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);
		
		$data['title'] = htmlspecialchars($data['title']);

		$post->update($data);

		$this->_tags($data['tags'], $post);
		$this->_files($data['files'], $post->id);

		// Parent post update if exists
		if ($data['parent_post'] != $post->post_id) {
			if (is_null(Post::find($data['parent_post'])))
				return Redirect::back()->withInput()->withErrors('Parent post not found');

			$post->post_id = $data['parent_post'];

			$post->save();
		}

		return Redirect::back()->with('success', 'Post updated seccessfully');
	}

	public function delete($id, $all = FALSE)
	{
		$post = TranslatedPost::find($id);
		
		if (is_null($post))
			return Redirect::back()->with('notice', 'Post not found');
		
		$title = $post->title;
		
		if ($all) {
			foreach ($post->parent->translated as $translated_post) {
				foreach ($translated_post->files as $file)
					$file->delete();
			}
			
			$message = 'The post "%s" and its translations successfully deleted';
		} else {
			foreach ($post->files as & $file)
				$file->delete();
			
			$message = 'The post "%s" successfully deleted';
		}
		
		$post->delete();
		
		return Redirect::back()->with('notice', sprintf($message, $title));
	}

	// Attach tags to the post
	private function _tags($data, & $post)
	{
		$new_tags = array();

		if (isset($data['titles'])) {
			for ($i = 0, $len = count($data['titles']); $i < $len; $i++) {
				if (isset($data['slugs'][$i], $data['titles'][$i])) {
					$slug = $data['slugs'][$i];
					$name = $data['titles'][$i];
				} else if (isset($data['titles'][$i]))
					$slug = $data['titles'][$i] = $name;
				else
					continue;
				
				$tag = Tag::firstOrCreate(['slug' => $slug, 'name' => $name]);
				
				array_push($new_tags, $tag->id);
			}
		}

		if (isset($data['ids']))
			$new_tags = array_merge($new_tags, $data['ids']);
			
		$post->tags()->sync($new_tags);
	}

	// Attach files to current post
	private function _files($files, $post_id)
	{
		if ($files)
			File::whereIn('id', $files)->update(array('post_id' => $post_id));
	}
}
