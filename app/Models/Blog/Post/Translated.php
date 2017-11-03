<?php

namespace App\Models\Blog\Post;

use App\Misc;
use Illuminate\Database\Eloquent\Model;

class Translated extends Model {
	
	protected $table    = 'blg_translated_posts';
	protected $fillable = ['slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'meta_title', 'markdown', 'date', 'id'];
	protected $dates    = ['date'];
	protected $appends  = ['url'];


	public static function boot()
	{
		parent::boot();
		
		$name = 'header_tags_' . request('locale');

		static::saved(function($post) use($name) {
			cache()->forget($name);
		});

		static::deleted(function($post) use($name) {
			cache()->forget($name);
		});

		static::saving(function($post) {
			// If post slug is empty use title
			if (strlen($post->slug) == 0) {
				$post->slug = $post->title;
			}

			// Escape title
			// $post->title = htmlspecialchars($post->title);

			// Prepare all code examples for browser in case of some HTML tags...
			/*
			if (is_null($post->markdown) or $post->markdown == FALSE) {
				$post->content = preg_replace_callback('/<code.*?>(.*?)<\/code>/imsu', function ($matches) {
					return str_replace($matches[1], htmlentities($matches[1]), $matches[0]);
				}, $post->content);
			}
			*/
			
			// Doublecheck the slug
			$post->slug = ru2lat($post->slug);
			$post->slug = strtolower(str_replace(' ', '_', $post->slug)); // Replace all spaces to _
			$post->slug = preg_replace('/[^a-zA-Z0-9_]/', '', $post->slug); // Replace everything except numbers, word chars and _ with nothing
		});
	}

	// ========================= Scopes ========================= //

	public function scopePermitted($query)
	{
		if (auth()->guest()) {
			$query->whereIn('status', ['published', 'hidden']);
		}

		return $query;
	}

	// ========================= Custom Methods ========================= //

	public function getURLAttribute()
	{
		return $this->getURL();
	}

	// ========================= Custom Methods ========================= //

	public function getProcessedContent($short = FALSE)
	{
		$content = $this->content;

		if ($short) {
			$content = current(explode('<!--break-->', $content));
		}

		if ($this->markdown) {
			$markdown_parser = new Misc\Post\MarkdownParser();

			$content = $markdown_parser->text($content);
		} else {
			$content = preg_replace_callback('/<code.*?>(.*?)<\/code>/imsu', function ($matches) {
				return Misc\Post\SyntaxHighlight::process($matches[1]);
			}, $content);
			// $content = Misc\Post\SyntaxHighlight::process($content);
		}

		return $content;
	}
	
	public function getURL()
	{
		return url(sprintf('/%s/post/%s', $this->locale, $this->slug));
	}

	public function getPostClass()
	{
		switch ($this->status) {
			case 'draft':
				$class = ' alert-warning';
				break;

			case 'hidden':
				$class = ' alert-danger';
				break;
			
			default:
				$class = '';
				break;
		}

		return $class;
	}

	// ========================= Relations ========================= //

	public function parent()
	{
		return $this->belongsTo(Post::class, 'parent_post_id');
	}
	
	public function tags()
	{
		return $this->belongsToMany(\App\Models\Blog\Tag::class, 'blg_posts_tags', 'post_id', 'tag_id');
	}
	
	public function files()
	{
		return $this->morphMany(\App\Models\File::class, 'fileable');
	}
}