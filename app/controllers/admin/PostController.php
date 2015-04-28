<?php
namespace Admin;

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
		$locales = Config::get('app.locales');
		
		return View::make('admin.posts.create')->with('locales', array_combine($locales, $locales));
	}

	public function store()
	{
		$data = Input::only('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'files', 'tags');
		
		$rules = array(
			'slug'    => array('required', 'unique:blg_translated_posts'),
			'title'   => array('required', 'min:5'),
			'locale'  => array('required', 'in:' . implode(',', Config::get('app.locales'))),
			'status'  => array('required', 'in:draft,published'),
			'content' => array('required', 'min:10'),
			'tags'  => array('array','min:1'),
			'files' => array('array','min:1'),
		);
		
		$validator = Validator::make(Input::all('text', 'title', 'image'), $rules);

		if ($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);
		
		$translated_post = new TranslatedPost($data);
				
		$post = new Post;
		
		$post->save();
		
		$post->translated()->save($translated_post);
		
		// Attach files to current post
		if (is_array($data['files']))
			File::whereIn('id', $data['files'])->update(array('post_id' => $translated_post->id));
		
		// Attach tags to current post
		if (is_array($data['tags'])) {
			$tags = array();
			
			for ($i = 0, $len = count($data['tags']['slugs']); $i < $len; $i++) {
				$tag = Tag::firstOrCreate(['slug' => $data['tags']['slugs'][$i], 'name' => $data['tags']['titles'][$i]]);
				
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
			$post->parent()->delete();
			$message = 'The post "%s" and its translations successfully deleted';
		} else {
			$post->delete();
			$message = 'The post "%s" successfully deleted';
		}
		
		return Redirect::back()->with('notice', sprintf($message, $title));
	}
}
