<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	protected $table = 'blg_posts';
		
	public function translated()
	{
		return $this->hasMany('App\Models\Blog\TranslatedPost', 'post_id');
	}
	
	public function locale($locale)
	{
		return $this->translated->filter(function($item) use($locale) {
			if ($item->locale == $locale)
				return True;
		})->first();
	}
	
	public function localesExcept($locale)
	{
		return $this->translated->filter(function($item) use($locale) {
			if ($item->locale != $locale)
				return True;
		});
	}
}
