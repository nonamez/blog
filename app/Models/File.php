<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	protected $table = 'files';
	protected $fillable = ['name', 'original_name', 'description'];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($file) {
			\Illuminate\Support\Facades\File::Delete($file->getPath());
		});
	}

	// ========================= Scopes ========================= //

	public function scopeOfType($query, $type)
	{
		$types = [
			'post'      => 'App\Models\Blog\TranslatedPost',
			'portfolio' => 'App\Models\Portfolio\Work'
		];

		if (array_key_exists($type, $types)) {
			$query->where('fileable_type', '=', $types[$type]);
		}

		return $query;
	}

	// ========================= Custom Methods ========================= //

	public function getPath()
	{
		$path = sprintf('%s/%s/%s', config('files.path'), $this->created_at->format('Y/m/d'), $this->name);
		
		return storage_path($path);
	}

	public function getURL()
	{
		return route('file.get', [$this->created_at->format('Y-m-d'), $this->name]);
	}

	public function getDeleteURL()
	{
		return route('admin.files.delete', $this->id);
	}

	// ========================= Relations ========================= //

	public function fileable()
	{
		return $this->morphTo();
	}
}