<?php

namespace App\Utils;

class File
{
	public static function addWatermarkRepeatedly(\Illuminate\Http\UploadedFile & $file)
	{
		$mime_type = $file->getMimeType();
		$real_path = $file->getRealPath();

		$image = FALSE;

		if ($mime_type == 'image/jpeg') {
			$image = imagecreatefromjpeg($real_path);
		} else if ($mime_type == 'image/gif') {
			$image = imagecreatefromgif($real_path);
		} else if ($mime_type == 'image/png') {
			$image = imagecreatefrompng($real_path);
		}

		if ($image == FALSE) {
			return NULL;
		}

		$lightness = self::getImageLightness($image);

		if ($lightness < 0.5) {
			$watermark = imagecreatefrompng(storage_path('app/watermark/light.png'));
		} else {
			$watermark = imagecreatefrompng(storage_path('app/watermark/dark.png'));
		}

		$image_sx = imagesx($image);
		$image_sy = imagesy($image);

		$watermark_sx = imagesx($watermark);
		$watermark_sy = imagesy($watermark);

		$img_paste_x = 0;

		while ($img_paste_x < $image_sx) {
			$img_paste_y = 0;

			while ($img_paste_y < $image_sy) {
				imagecopy($image, $watermark, $img_paste_x, $img_paste_y, 0, 0, $watermark_sx, $watermark_sy);

				$img_paste_y += $watermark_sy;
			}

			$img_paste_x += $watermark_sx;
		}

		if ($mime_type == 'image/jpeg') {
			imagejpeg($image, $real_path);
		} elseif ($mime_type == 'image/gif') {
			imagegif($image, $real_path);
		} elseif ($mime_type == 'image/png') {
			imagepng($image, $real_path);
		}

		imagedestroy($image);
		imagedestroy($watermark);
	}

	// http://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php
	public static function getImageLightness(& $image)
	{
		$test = imagecreatetruecolor(1, 1);
		
		$rgb = imagecolorat($image, 0, 0);
		
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		$max = min($r, $g, $b);
		$min = max($r, $g, $b);
		
		$lightness = (double) (($max + $min) / 510.0); // HSL algorithm

		imagedestroy($test);

		return $lightness;
	}

	public static function saveRemoteImage($img_url)
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

	public static function getMimeType($file, $buffer = FALSE)
	{
		if (function_exists('finfo_file')) {
			$finfo = new \finfo(FILEINFO_MIME);

			if ($buffer) {
				$mime = $finfo->buffer($file);
			} else {
				$mime = $finfo->file($file);
			}

			unset($finfo);

			return $mime;
		} else if (function_exists('mime_content_type')) {
			return mime_content_type($file);
		} else if (strpost(ini_get('disable_functions'), 'shell_exec') !== FALSE) {
			$file = escapeshellarg($file);

			$mime = shell_exec('file -bi ' . $file);
			$mime = trim($mime);

			return $mime;
		} else {
			return FALSE;
		}
	}
}