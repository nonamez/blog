<?php

namespace App\Helpers\Admin;

use DB;
use File as FileHelper;
use App\Models\File as FileModel;

class File
{
	// Attach files to current post
	public static function attach(array $files, $parent_id, $type)
	{
		if (count($files) > 0)
			DB::table('files')->where('type', '=', $type)->whereIn('id', $files)->update(['parent_id' => $parent_id]);
	}

	public static function deleteAll(\Illuminate\Database\Eloquent\Collection $files, $type)
	{
		if ($files->count() > 0) {
			foreach ($files as $file)
				FileHelper::Delete($file->getPath());

			DB::table('files')->where('type', '=', $type)->whereIn('id', $files->lists('id'))->delete();
		}
	}
}