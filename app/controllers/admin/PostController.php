<?php
namespace Admin;

use Config;
use View;

class PostController extends \BaseController {

	public function index()
	{
		return View::make('admin.posts.index');
	}

	public function create()
	{
		$locales = Config::get('app.locales');
		
		return View::make('admin.posts.create')->with('locales', array_combine($locales, $locales));
	}


	public function store()
	{
		//
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
