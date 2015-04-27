<?php
namespace Admin;

use URL;
use View;
use Input;
use Config;
use Redirect;
use Validator;

use Blog\Models\File;
use Blog\Models\TranslatedPost;

class FileController extends \BaseController {
	
	private $_upload_path;
	
	function __construct()
	{
		$path = storage_path(Config::get('blog.upload_path'));
		
		if (is_dir($path) == FALSE)
			mkdir($path);
		
		$this->_upload_path = $path;
	}

	public function store()
	{
		$file = Input::file('file');
		
		$rule = array(
			'file' => 'required|mimes:jpeg,bmp,png,zip|max:250',
		);
		
		$validator = Validator::make(compact('file'), $rule);

		if ($validator->fails())
			return $this->simpleAjaxResponse(array('error' => TRUE, 'message' => $validator->messages()->first()));

		$name = str_random(5) . $file->getClientOriginalName();
		
		$file->move($this->_upload_path, $name);
		
		File::create(array(
			'name'       => $file->getClientOriginalName(),
			'local_name' => $name
		));
		
		$url = URL::route('file_get', array('name' => $file->getClientOriginalName()));
		
		return $this->simpleAjaxResponse(array('error' => FALSE, 'data' => $url));
	}
}
