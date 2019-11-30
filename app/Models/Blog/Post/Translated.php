<?php

namespace App\Models\Blog\Post;

use App\Misc;
use Illuminate\Database\Eloquent\Model;

class Translated extends Model {
	
	protected $table    = 'blg_translated_posts';
	protected $fillable = ['title', 'locale', 'status', 'content', 'meta_keywords', 'meta_description', 'meta_title', 'markdown', 'date'];
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
		return (object) [
			'preview' => $this->getURL(),
			
			'save' => route('dashboard.posts.save', $this->id),
			'find' => route('dashboard.posts.find', $this->id)
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

	public function getURL()
	{
		return url(sprintf('/%s/post/%s', $this->locale, $this->slug));
	}

	// ========================= Relations ========================= //

	public function parent()
	{
		return $this->belongsTo(Post::class, 'parent_id');
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