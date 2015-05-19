<?php namespace Blog\Models;

use Config;
use Eloquent;

class File extends Eloquent {

	protected $table = 'blg_files';
	protected $fillable = array('name', 'original_name');

	public function post()
	{
		return $this->belongsTo('Blog\Models\TranslatedPost', 'post_id');
	}
	
	public static function boot()
	{
		parent::boot();

		static::deleting(function($file)
		{
			$path = storage_path(Config::get('blog.upload_path') . date('/Y/m/d', strtotime($file->created_at)));
			
			$file_path = $path . '/' . $file->name;
			
			\Illuminate\Support\Facades\File::delete($file_path);
		});
	}
}