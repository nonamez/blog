<?php

namespace App\Models;

use App\Events;

use Illuminate\Database\Eloquent\Model;


class File extends Model {

	protected $table    = 'files';
	protected $fillable = ['name', 'description'];

	protected $appends  = ['routes'];

	protected $visible = ['id', 'name', 'original_name', 'description', 'created_at', 'routes', 'fileable'];

	protected $dispatchesEvents = [
		'deleting' => Events\File\Deleting::class,
	];

	// ========================= Attributes ========================= //

	public function getRoutesAttribute()
	{
		return (object) [
			'preview' => $this->getURL(),
			
			'update' => route('dashboard.files.update', $this->id),
			'delete' => route('dashboard.files.delete', $this->id)
		];  
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