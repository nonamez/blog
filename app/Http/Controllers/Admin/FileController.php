<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileRequest;

use URL;
use File;
use View;
use Config;
use Storage;
use Response;

class FileController extends Controller {
	
	const BLOG_UPLOAD_PATH = 'app/blog/uploads';
	
	public function get($date, $name)
	{
		$file_path = str_replace('-', '/', $date) . '/' . $name;
		$file_path = storage_path(self::BLOG_UPLOAD_PATH . '/' . $file_path);

		if (File::exists($file_path) == FALSE)
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
		
		$file_type = File::type($file_path);
	
		return Response::make(File::get($file_path), 200)->header('Content-Type', $file_type);
	}

	public function store(FileRequest $request)
	{
		$file = $request->file('file');
		$time = time();
		
		$path = storage_path(self::BLOG_UPLOAD_PATH . date('/Y/m/d', $time));
		
		if (File::isDirectory($path) == FALSE)
			File::makeDirectory($path, 0755, TRUE);
		
		$name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension()) . '_' . str_random(5) . '.' . $file->guessExtension();
		$name = strtolower($name);
		
		$file->move($path, $name);
		
		$file = Blog\File::create([
			'name' => $name,
			'original_name' => $file->getClientOriginalName(),
		]);
		
		$data = [
			'id'  => $file->id,
			'url' => URL::route('file_get', [date('Y-m-d', $time), $file->name])
		];
		
		return $this->ajaxResponse(['error' => FALSE, 'data' => $data]);
	}
	
	public function delete($file_id)
	{
		$file = Blog\File::find($file_id);
		
		$file->delete();
		
		return $this->ajaxResponse(['error' => FALSE]);
	}
}
