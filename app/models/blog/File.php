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
	
	public function delete()
	{
		$path = storage_path(Config::get('blog.upload_path') . date('/Y/m/d', strtotime($this->created_at)));
		
		$file_path = $path . '/' . $this->name;
		
		\Illuminate\Support\Facades\File::delete($file_path);
		
		parent::delete();
	}
}