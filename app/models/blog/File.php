<?php namespace Blog\Models;

use Eloquent;

class File extends Eloquent {

	protected $table = 'blg_files';
	protected $fillable = array('name', 'original_name');

	public function post()
	{
		return $this->belongsTo('Blog\Models\TranslatedPost', 'post_id');
	}
}