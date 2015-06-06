<?php namespace Blog\Models;

use Cache;
use Input;
use Eloquent;

class TranslatedPost extends Eloquent {
	
	protected $table    = 'blg_translated_posts';
	protected $guarded  = array('id');
	protected $fillable = array('slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description');

	public $is_short = FALSE;

	public static function boot()
	{
		parent::boot();

		$name = 'tags_in_header_' . Input::get('locale');

		static::saved(function($post) use($name) {
			Cache::forget($name);
		});

		static::deleted(function($post) use($name) {
			Cache::forget($name);
		});
	}
	
	public function parent()
	{
		return $this->belongsTo('Blog\Models\Post', 'post_id', 'id');
	}
	
	public function tags()
	{
		return $this->belongsToMany('Blog\Models\Tag', 'blg_posts_tags', 'post_id', 'tag_id');
	}
	
	public function files()
	{
		return $this->hasMany('Blog\Models\File', 'post_id', 'id');
	}
	
	public function short()
	{
		$exploded = explode('<!--break-->', $this->content);

		$this->is_short = count($exploded) == 2;

		return current($exploded);
	}
}
