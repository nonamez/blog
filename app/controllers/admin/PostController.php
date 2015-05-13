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

	public function index()
	{
		$paginated = TranslatedPost::orderBy('created_at', 'DESC')->paginate(5);
		
		return View::make('admin.posts.index')->with('posts', $paginated);
	}

	public function create()
	{
		$posts   = Post::orderBy('id', 'DESC')->take(5)->lists('id');
		$locales = Config::get('app.locales');
		
		$today = date('Y-m-d');
		
		$data = array(
			'tags'    => Input::old('tags'),
			// Selecting files that was uploaded today, but not yet assignet to the post
			'files'   => File::where('post_id', '=', NULL)->where(DB::raw('DATE(`created_at`)'), '=', $today)->lists('name', 'id'),
			'posts'   => array_combine($posts, $posts),
			'locales' => array_combine($locales, $locales)
		);
		
		foreach ($data['files'] as & $file)
			$file = URL::route('file_get', array($today, $file));
		
		return View::make('admin.posts.create', $data);
	}

	public function store()
	{
		$data = Input::only('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'files', 'tags', 'parent_post');
		
		$rules = array(
			'slug'    => array('required', 'unique:blg_translated_posts'),
			'title'   => array('required', 'min:5'),
			'locale'  => array('required', 'in:' . implode(',', Config::get('app.locales'))),
			'status'  => array('required', 'in:draft,published'),
			'content' => array('required', 'min:10'),
			'tags'    => array('array','min:1'),
			'files'   => array('array','min:1'),
			'parent_post' => array('exists:blg_posts,id', 'integer')
		);
		
		$validator = Validator::make(Input::all('text', 'title', 'image'), $rules);

		if ($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);
		
		$translated_post = new TranslatedPost($data);
		
		// Select parent or create new
		if (is_numeric($data['parent_post'])) {
			$post = Post::find($data['parent_post']);
		} else {
			$post = new Post;
			
			$post->save();
		}
		
		try {
			$post->translated()->save($translated_post);
		} catch(\Illuminate\Database\QueryException $e) {
			// If post with selected locale already exists
			if (strpos($e->getMessage(), 'blg_translated_posts_post_id_locale_unique'))
				return Redirect::back()->withInput()->withErrors(sprintf('Post with language <strong>"%s"</strong> and id <strong>%s</strong> exists', $data['locale'], $data['parent_post']));
			
			// If the error is not recognized
			throw $e;
		}
		
		// Attach files to current post
		if (is_array($data['files']))
			File::whereIn('id', $data['files'])->update(array('post_id' => $translated_post->id));
		
		// Attach tags to current post
		if (is_array($data['tags'])) {
			$tags = array();
			
			for ($i = 0, $len = count($data['tags']['titles']); $i < $len; $i++) {
				if (isset($data['tags']['slugs'][$i], $data['tags']['titles'][$i])) {
					$slug = $data['tags']['slugs'][$i];
					$name = $data['tags']['titles'][$i];
				} else if (isset($data['tags']['titles'][$i]))
					$slug = $data['tags']['titles'][$i] = $name;
				else
					continue;
				
				$tag = Tag::firstOrCreate(['slug' => $slug, 'name' => $name]);
				
				array_push($tags, $tag->id);
			}
			
			$translated_post->tags()->attach($tags);
		}
		
		return Redirect::to('/admin');
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
}
