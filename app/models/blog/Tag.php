<?php namespace Blog\Models;

use DB;
use Eloquent;

class Tag extends Eloquent {
	protected $table = 'blg_tags';
	protected $fillable = array('slug', 'name');
	protected $guarded = array('id');
	
	public $timestamps = FALSE;
	
	public function translated_posts()
	{
		return $this->belongsToMany('Blog\Models\TranslatedPost', 'blg_posts_tags', 'tag_id', 'post_id');
	}

	// Not the best approach, but currently for few tags it would be ok. 
	// Will rewrite in the future
	public function scopeOrdered($query)
	{
		$raw_table = DB::getTablePrefix() . 'blg_posts_tags';

		$query->join('blg_posts_tags', 'blg_posts_tags.tag_id', '=', 'blg_tags.id');

		$query->groupBy('blg_posts_tags.tag_id');
		$query->orderBy(DB::raw("count(`$raw_table`.`tag_id`)"), 'desc');

		return $query;
	}
}