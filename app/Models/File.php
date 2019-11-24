<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	protected $table    = 'files';
	protected $fillable = ['name', 'description'];

	protected $appends  = ['routes'];

	protected $visible = ['id', 'name', 'description', 'routes', 'private'];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($file) {
			\Illuminate\Support\Facades\File::delete($file->getPath());
		});
	}

	// ========================= Attributes ========================= //

	public function getRoutesAttribute()
	{
		return (object) [
			'preview' => $this->getURL(),
			
			'update' => route('dashboard.files.update', $this->id),
			'delete' => route('dashboard.files.delete', $this->id)
		];  
	}

	// ========================= Scopes ========================= //

	public function scopeOfType($query, $type)
	{
		$types = [
			'post'      => 'App\Models\Blog\TranslatedPost',
		];

		if (array_key_exists($type, $types)) {
			$query->where('fileable_type', '=', $types[$type]);
		}

		return $query;
	}

	// ========================= Custom Methods ========================= //

	public function getPath()
	{
		$path = sprintf('app/public/%s/%s', $this->created_at->format('Y/m/d'), $this->name);
		
		return storage_path($path);
	}

	public function getURL()
	{
		return route('storage.file', [$this->created_at->format('Y/m/d'), $this->name]);
	}

	// ========================= Relations ========================= //

	public function fileable()
	{
		return $this->morphTo();
	}
}