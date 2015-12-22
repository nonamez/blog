<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class TranslatedPost extends Model {
	
	protected $table    = 'blg_translated_posts';
	protected $fillable = ['slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description'];

	public $is_short = FALSE;

	public static function boot()
	{
		parent::boot();
		
		$name = 'tags_in_header_' . request('locale');

		static::saved(function($post) use($name) {
			\Cache::forget($name);
		});

		static::deleted(function($post) use($name) {
			\Cache::forget($name);
		});

		static::saving(function($post)
		{
			$post->content = preg_replace_callback('/<code.*?>(.*?)<\/code>/imsu', function ($matches) {
				return str_replace($matches[1], htmlentities($matches[1]), $matches[0]);
			}, $post->content);
		});
	}
	
	public function parent()
	{
		return $this->belongsTo('App\Models\Blog\Post', 'post_id');
	}
	
	public function tags()
	{
		return $this->belongsToMany('App\Models\Blog\Tag', 'blg_posts_tags', 'post_id', 'tag_id');
	}
	
	public function files()
	{
		return $this->hasMany('App\Models\Blog\File', 'post_id');
	}
	
	public function short()
	{
		$exploded = explode('<!--break-->', $this->content);

		$this->is_short = count($exploded) == 2;

		return current($exploded);
	}
}
