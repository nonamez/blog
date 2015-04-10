<?php
namespace Admin;

use View;
use Input;
use Config;
use Redirect;
use Validator;

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
		$data = Input::only('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description');
		
		$rules = array(
			'slug'    => array('required', 'unique:blg_translated_posts'),
			'title'   => array('required', 'min:5'),
			'locale'  => array('required', 'in:' . implode(',', Config::get('app.locales'))),
			'status'  => array('required', 'in:draft,published'),
			'content' => array('required', 'min:10'),
		);
		
		$validator = Validator::make(Input::all('text', 'title', 'image'), $rules);

		if ($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);
		
		$translated_post = new TranslatedPost($data);
		
		$post = new Post;
		
		$post->save();
		
		$post->translated()->save($translated_post);
		
		return Redirect::to('/admin');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
