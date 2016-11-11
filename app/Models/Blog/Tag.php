<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

use DB;

class Tag extends Model {
	protected $table    = 'blg_tags';
	protected $fillable = ['slug', 'name'];
	
	public $timestamps = FALSE;

	// ========================= Scopes ========================= //

	public function scopeOrdered($query)
	{
		$raw_table = DB::getTablePrefix() . 'blg_posts_tags';

		$query->join('blg_posts_tags', 'blg_posts_tags.tag_id', '=', 'blg_tags.id');

		$query->groupBy('blg_posts_tags.tag_id');
		$query->orderBy(DB::raw(sprintf('count(`%s`.`tag_id`)', $raw_table)), 'desc');

		return $query;
	}

	// ========================= Relations ========================= //

	public function translated_posts()
	{
		return $this->belongsToMany(TranslatedPost::class, 'blg_posts_tags', 'tag_id', 'post_id');
	}
}