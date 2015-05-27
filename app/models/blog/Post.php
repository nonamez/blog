<?php namespace Blog\Models;

use Eloquent;

class Post extends Eloquent {

	protected $table = 'blg_posts';
	protected $primary_key = 'id';
		
	public function translated()
	{
		return $this->hasMany('Blog\Models\TranslatedPost', 'post_id');
	}
	
	public function locale($locale) {
		return $this->translated->filter(function($item) use($locale)
		{
			if ($item->locale == $locale)
				return True;
		})->first();
	}
	
	public function localeNot($locale) {
		return $this->translated->filter(function($item) use($locale)
		{
			if ($item->locale != $locale)
				return True;
		});
	}
}