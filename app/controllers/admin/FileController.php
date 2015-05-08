<?php
namespace Admin;

use URL;
use File;
use View;
use Input;
use Config;
use Response;
use Redirect;
use Validator;

use Blog\Models\File as FileModel;
use Blog\Models\TranslatedPost;

class FileController extends \BaseController {
	
	public function get($date, $name)
	{
		$file_path = str_replace('-', '/', $date) . '/' . $name;
		$file_path = storage_path(Config::get('blog.upload_path') . '/' . $file_path);

		if (File::exists($file_path) == FALSE)
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
		
		$file_type = File::type($file_path);
	
		return Response::make(File::get($file_path), 200)->header('Content-Type', $file_type);
	}

	public function store()
	{
		$file = Input::file('file');
		
		$rule = array(
			'file' => array('required', 'mimes:jpeg,bmp,png,zip,pdf'),
		);
		
		$validator = Validator::make(compact('file'), $rule);

		if ($validator->fails())
			return $this->simpleAjaxResponse(array('error' => TRUE, 'message' => $validator->messages()->first()));
		
		$path = storage_path(Config::get('blog.upload_path') . date('/Y/m/d'));
		
		if (is_dir($path) == FALSE)
			mkdir($path, 0777, TRUE);
		
		$name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension()) . '_' . str_random(5) . '.' . $file->guessExtension();
		$name = strtolower($name);
		
		$file->move($path, $name);
		
		$file = FileModel::create(array(
			'name' => $name,
			'original_name' => $file->getClientOriginalName(),
		));
		
		$data = array(
			'id'  => $file->id,
			'url' => URL::route('file_get', array(date('Y-m-d'), $file->name))
		);
		
		return $this->simpleAjaxResponse(array('error' => FALSE, 'data' => $data));
	}
	
	public function delete($id)
	{
		$file = FileModel::find($id);
		
		if (is_null($file))
			return $this->simpleAjaxResponse(array('error' => TRUE, 'message' => 'File not found'));
		
		$file->delete();
		
		return $this->simpleAjaxResponse(array('error' => FALSE));
	}
}
