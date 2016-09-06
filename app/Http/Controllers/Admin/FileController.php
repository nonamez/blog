<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Utils;
use App\Models\File as FileModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileRequest;

use File;

class FileController extends Controller {
	
	public function index()
	{
		$files = FileModel::orderBy('created_at', 'DESC')->paginate(20);

		return view('admin.files.index', compact('files'));
	}
	
	public function get($date, $name)
	{
		$file_path = str_replace('-', '/', $date) . '/' . $name;
		$file_path = storage_path(FileModel::getUploadPath() . '/' . $file_path);

		if (File::exists($file_path) == FALSE)
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
		
		$file_type = File::type($file_path);
	
		return response(File::get($file_path), 200)->header('Content-Type', $file_type);
	}

	public function store(FileRequest $request)
	{
		$file = $request->file('file');
		$time = time();
		
		$path = storage_path(FileModel::getUploadPath() . date('/Y/m/d', $time));
		
		if (File::isDirectory($path) == FALSE)
			File::makeDirectory($path, 0755, TRUE);

		if ($request->get('watermark', FALSE))
			Utils\File::addWatermarkRepeatedly($file);

		$name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
		$name = str_replace(' ', '_', $name);
		$name = preg_replace("/[^\w]+/", '', $name);
		$name = sprintf('%s_%s.%s', $name, str_random(5), $file->guessExtension());
		$name = strtolower($name);
		
		$file->move($path, $name);
		
		$file = FileModel::create([
			'name'          => $name,
			'type'          => $request->get('type', 'none'),
			'description'   => $request->get('description', NULL),
			'original_name' => $file->getClientOriginalName()
		]);
		
		$data = [
			'id'  => $file->id,
			'url' => $file->getURL(),
			'description' => $file->description
		];
		
		return $this->ajaxResponse(['error' => FALSE, 'data' => $data]);
	}
	
	public function update($file_id, Request $request)
	{
		$file = FileModel::find($file_id);

		if (is_null($request->description) == FALSE)
			$file->update(['description' => $request->description]);
		
		if ($request->ajax())
			return $this->ajaxResponse(['error' => FALSE]);
		else
			return redirect()->back();
	}

	public function delete($file_id, Request $request)
	{
		$file = FileModel::find($file_id);
		
		$file->delete();
		
		if ($request->ajax())
			return $this->ajaxResponse(['error' => FALSE]);
		else
			return redirect()->back();
	}
}
