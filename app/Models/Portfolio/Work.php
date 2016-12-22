<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
	protected $table    = 'prf_works';
	protected $fillable = ['title', 'description'];

	// ========================= Custom Methods ========================= //

	public function getPreviewImage()
	{
		if ($this->images->count() > 0) {
			$image = $this->images->first();

			return $image->getURL();
		}

		return url('/storage/images/no_image.jpg');
	}

	// ========================= Relations ========================= //

	public function images()
	{
		return $this->morphMany(\App\Models\File::class, 'fileable');
	}
}
