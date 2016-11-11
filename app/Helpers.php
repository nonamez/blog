<?php


/**
 * Upload the image and attach to given model
 */

if (function_exists('saveRemoteImage') == FALSE) {
	function saveRemoteImage($img_url)
	{
		$file_path = storage_path('app/files/' . date('Y/m/d'));

		if (is_dir($file_path) == FALSE) {
			mkdir($file_path, 0777, TRUE);
		}

		$headers = get_headers($img_url);

		$response_status = substr($headers[0], 9, 3);

		if ($response_status != 200) {
			return NULL;
		}

		$image = file_get_contents($img_url);

		$ext = pathinfo($img_url, PATHINFO_EXTENSION);

		if (strlen($ext) == 0) {
			$finfo = new finfo(FILEINFO_MIME);

			$mime_type = $finfo->buffer($image);

			if (strpos($mime_type, 'image/jpeg') !== FALSE) {
				$ext = 'jpeg';
			} elseif ($mime_type == 'image/gif') {
				$ext = 'gif';
			} elseif ($mime_type == 'image/png') {
				$ext = 'png';
			} else {
				return  FALSE;
			}
		}

		$file_name = sprintf('%s.%s', str_random(12), $ext);

		file_put_contents($file_path . '/' . $file_name, $image);

		$new_file = new App\Models\File;

		$new_file->name = $file_name;
		$new_file->original_name = pathinfo($img_url, PATHINFO_FILENAME);

		$new_file->save();

		return $new_file;
	}
}