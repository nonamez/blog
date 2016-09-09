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
			// If post slug is empty use title
			if (strlen($post->slug) == 0)
				$post->slug = $post->title;

			// Escape title
			$post->title = htmlspecialchars($post->title);

			// We also need to escape content but as I am the only user of the system we will skip this...

			// Prepare all code examples for browser in case of some HTML tags...
			$post->content = preg_replace_callback('/<code.*?>(.*?)<\/code>/imsu', function ($matches) {
				return str_replace($matches[1], htmlentities($matches[1]), $matches[0]);
			}, $post->content);

			// Doublecheck the slug
			$post->slug = strtolower(str_replace(' ', '_', $post->slug)); // Replace all spaces to _
			$post->slug = preg_replace('/[^a-zA-Z0-9_]/', '', $post->slug); // Replace everything except numbers, word chars and _ with nothing
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
		return $this->hasMany('App\Models\File', 'parent_id')->where('type', '=', 'post');
	}
	
	public function short()
	{
		$exploded = explode('<!--break-->', $this->content);

		$this->is_short = count($exploded) == 2;

		return current($exploded);
	}

	public function getURL()
	{
		return url(sprintf('/%s/post/%s', $this->locale, $this->slug));
	}
}