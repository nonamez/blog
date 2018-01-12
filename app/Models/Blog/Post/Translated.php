<?php

namespace App\Models\Blog\Post;

use App\Misc;
use Illuminate\Database\Eloquent\Model;

class Translated extends Model {
	
	protected $table    = 'blg_translated_posts';
	protected $fillable = ['slug', 'title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'meta_title', 'markdown', 'date', 'id'];
	protected $dates    = ['date'];

	protected $appends  = ['routes'];

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

	// ========================= Attributes ========================= //

	public function getRoutesAttribute()
	{
		return [
			'preview' => url(sprintf('/%s/post/%s', $this->locale, $this->slug)),
			'edit'    => route('admin.posts.edit', $this->id),
			'update'  => route('admin.posts.update', $this->id)
		];  
	}

	// ========================= Custom Methods ========================= //

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