<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models;

class Tag extends Model
{
	use HasFactory;

	protected $table = 'blg_tags';

	protected $fillable = ['slug', 'name'];

	// ========================= Relations ========================= //

	public function posts()
	{
		return $this->belongsToMany(Models\Posts\Translated::class, 'blg_translated_posts_tags', 'tag_id', 'post_id')->withTimestamps();
	}

	// ========================= Custom Methods ========================= //

	public function getUrl()
	{
		return route('blog.posts.tag', [app()->getLocale(), $this->slug]);
	}

}
