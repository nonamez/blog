<?php

namespace App\Http\Controllers\Dashboard\Files;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Utils;
use App\Models;

use App\Http\Resources;
use App\Http\Controllers\Controller;

class FileController extends Controller {

	const ALLOWED_TYPES = ['jpeg', 'bmp', 'png', 'zip', 'pdf'];
	
	public function index()
	{
		$files = Models\Files\File::with('fileable:id,title,locale,slug')->orderBy('created_at', 'DESC')->paginate(20);

		return response()->json(compact('files'));
	}
	
	public function store(Request $request)
	{
		// ToDo: validate id and model
		$request->validate([
			'file' => ['required', 'mimes:' . implode(',', self::ALLOWED_TYPES)],
			'watermark' => ['required', 'boolean'],
		]);

		$file = $request->file('file');
		$time = time();

		$path = 'app/public';
		$path = $path . date('/Y/m/d', $time);
		$path = storage_path($path);
				
		if (File::isDirectory($path) == FALSE) {
			File::makeDirectory($path, 0755, TRUE);
		}

		$file_real_path = $file->getRealPath();

		if ((boolean) $request->get('watermark', FALSE) && exif_imagetype($file_real_path)) {
			Utils\Image::addWatermarkRepeatedly($file_real_path);
		}

		$name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
		$name = Str::slug($name, '-');
		$name = sprintf('%s_%s.%s', substr($name, 0, 30), Str::random(7), $file->getClientOriginalExtension());
		
		$file->move($path, $name);
		
		$new_file = new Models\Files\File;

		$new_file->name          = $name;
		// $new_file->description   = $request->get('description', NULL);
		$new_file->original_name = $file->getClientOriginalName();

		if ($request->has(['id', 'model'])) {
			$new_file->fileable_id   = $request->get('id');
			$new_file->fileable_type = $request->get('model');
		}

		$new_file->save();

		return new Resources\Files\File($new_file);
	}
	
	public function update(Request $request, $file_id)
	{
		$file = Models\Files\File::findOrFail($file_id);

		if ($request->description) {
			$file->update($request->only('description'));
		}
		
		if ($request->ajax()) {
			return response()->json();
		} else {
			return redirect()->back();
		}
	}

	public function delete(Request $request, $file_id)
	{
		$file = Models\Files\File::findOrFail($file_id);

		$file->delete();
		
		return response()->json();
	}
}