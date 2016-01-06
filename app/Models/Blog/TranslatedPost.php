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
			// If post slug empty using title
			if (strlen($post->slug) == 0)
				$post->slug = preg_replace('/[^ \w]+/', '', $post->title); // Replace all non-space and non-word characters with nothing

			// Escape title
			$post->title = htmlspecialchars($post->title);

			// We aslo need to excape content but as I'm am the obly user of the system we will skip this...

			// Prepare all code examples for browser in case of some HTML tags...
			$post->content = preg_replace_callback('/<code.*?>(.*?)<\/code>/imsu', function ($matches) {
				return str_replace($matches[1], htmlentities($matches[1]), $matches[0]);
			}, $post->content);

			// Doublecheck the slug
			$post->slug = strtolower(str_replace(' ', '_', $post->slug));
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
