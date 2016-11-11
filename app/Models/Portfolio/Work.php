<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
	protected $table    = 'prf_works';
	protected $fillable = ['title', 'description'];

	public function images()
	{
		return $this->morphMany(\App\Models\File::class, 'fileable');
	}
}
