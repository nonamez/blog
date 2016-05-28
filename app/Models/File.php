<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	const UPLOAD_PATH = 'app/uploads';

	protected $table = 'files';
	protected $fillable = ['name', 'original_name', 'description', 'type'];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($file) {
			\Illuminate\Support\Facades\File::Delete($file->getPath());
		});
	}

	public function getPath()
	{
		$path = sprintf('%s/%s/%s', self::getUploadPath(), $this->created_at->format('Y/m/d'), $this->name);
		
		return storage_path($path);
	}

	public function getURL()
	{
		return route('file_get', [$this->created_at->format('Y-m-d'), $this->name]);
	}

	public static function getUploadPath()
	{
		return self::UPLOAD_PATH;
	}

	public function post()
	{
		return $this->belongsTo(Blog\TranslatedPost::class, 'parent_id');
	}

	public function portfolio()
	{
		return $this->belongsTo(Portfolio\Work::class, 'parent_id');
	}
}