<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	protected $table = 'files';
	protected $fillable = ['name', 'original_name'];

	public function post()
	{
		return $this->belongsTo('App\Models\Blog\TranslatedPost', 'parent_id')->where('type', '=', 'post');
	}
	
	public static function boot()
	{
		parent::boot();

		static::deleting(function($file)
		{
			$path = \App\Http\Controllers\Admin\FileController::UPLOAD_PATH;
			$path = storage_path($path. date('/Y/m/d', strtotime($file->created_at)));
			
			$file_path = $path . '/' . $file->name;
			
			\Illuminate\Support\Facades\File::delete($file_path);
		});
	}
}