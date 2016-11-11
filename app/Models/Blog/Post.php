<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	protected $table = 'blg_posts';

	// ========================= Custom Methods ========================= //
		
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

	// ========================= Relations ========================= //
		
	public function translated()
	{
		return $this->hasMany(TranslatedPost::class, 'post_id');
	}
}
