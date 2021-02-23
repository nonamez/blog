<?php

namespace App\Models\Blog\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use HasFactory;

	protected $table = 'blg_posts';

	// ========================= Relations ========================= //

	public function user()
	{
		return $this->belongsTo(Models\Users\User::class);
	}

	public function translations()
	{
		return $this->hasMany(Translated::class, 'parent_post_id');
	}

	// ========================= Custom Methods ========================= //
		
	public function locale($locale)
	{
		return $this->translations->filter(function($item) use($locale) {
			if ($item->locale == $locale) {
				return True;
			}
		})->first();
	}
	
	public function localesExcept($locale)
	{
		return $this->translations->filter(function($item) use($locale) {
			if ($item->locale != $locale) {
				return TRUE;
			}
		});
	}
}
