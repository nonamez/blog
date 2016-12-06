<?php

namespace App\Http\Controllers\Admin\Files;

use Illuminate\Http\Request;

use App\Utils;
use App\Models;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileRequest;

use File;

class FileController extends Controller {

	private $files_path;

	function __construct()
	{
		$this->files_path = config('files.path');
	}
	
	public function index()
	{
		$files = Models\File::orderBy('created_at', 'DESC')->paginate(20);

		return view('admin.files.index', compact('files'));
	}
	
	public function get($date, $name)
	{
		$file_path = str_replace('-', '/', $date) . '/' . $name;
		$file_path = storage_path($this->files_path . '/' . $file_path);

		if (File::exists($file_path) == FALSE) {
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
		}
		
		$file_type = Utils\File::getMimeType($file_path);

		return response(File::get($file_path), 200)->header('Content-Type', $file_type);
	}

	public function store(FileRequest $request)
	{
		$file = $request->file('file');
		$time = time();
		
		$path = storage_path($this->files_path . date('/Y/m/d', $time));
		
		if (File::isDirectory($path) == FALSE) {
			File::makeDirectory($path, 0755, TRUE);
		}

		if ($request->get('watermark', FALSE) && exif_imagetype($file->getRealPath())) {
			Utils\File::addWatermarkRepeatedly($file);
		}

		$name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
		$name = str_replace(' ', '_', $name);
		$name = preg_replace("/[^\w]+/", '', $name);
		$name = strlen($name) > 50 ? sprintf('%s_%s', substr($name, 0, 30), str_random(10)) : $name;
		$name = sprintf('%s_%s.%s', $name, str_random(5), $file->getClientOriginalExtension());
		$name = strtolower($name);
		
		$file->move($path, $name);
		
		$file = Models\File::create([
			'name'          => $name,
			'description'   => $request->get('description', NULL),
			'original_name' => $file->getClientOriginalName()
		]);
		
		$data = [
			'id'   => $file->id,
			'name' => $file->name,
			'description' => $file->description,

			'get_url' => $file->getURL(),
			'del_url' => $file->getDeleteURL(),
		];
		
		return response()->json($data);
	}
	
	public function update($file_id, Request $request)
	{
		$file = Models\File::findOrFail($file_id);

		if ($request->description) {
			$file->update(['description' => $request->description]);
		}
		
		if ($request->ajax()) {
			return response()->json();
		} else {
			return redirect()->back();
		}
	}

	public function delete(Request $request, $file_id)
	{
		$file = Models\File::findOrFail($file_id);

		$file->delete();
		
		if ($request->ajax()) {
			return response()->json();
		} else {
			return redirect()->back();
		}
	}
}