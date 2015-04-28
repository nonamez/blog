<?php
namespace Admin;

use URL;
use File;
use View;
use Input;
use Config;
use Redirect;
use Validator;

use Blog\Models\File as FileModel;
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
		
		$file = FileModel::create(array(
			'name'       => $file->getClientOriginalName(),
			'local_name' => $name
		));
		
		$data = array(
			'id'  => $file->id,
			'url' => URL::route('file_get', array('name' => $file->name))
		);
		
		return $this->simpleAjaxResponse(array('error' => FALSE, 'data' => $data));
	}
	
	public function delete($id)
	{
		$file = FileModel::find($id);
		
		if (is_null($file))
			return $this->simpleAjaxResponse(array('error' => TRUE, 'message' => 'File not found'));
		
		$filename = $this->_upload_path . '/' . $file->local_name;
		
		File::delete($filename);
		
		$file->delete();
		
		return $this->simpleAjaxResponse(array('error' => FALSE));
	}
}
