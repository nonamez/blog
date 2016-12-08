<?php

namespace App\Utils;

class Image
{
	public static function addWatermarkRepeatedly($image_path)
	{
		$mime_type = exif_imagetype($image_path);

		$image = FALSE;

		if ($mime_type == IMAGETYPE_JPEG) {
			$image = imagecreatefromjpeg($image_path);
		} else if ($mime_type == IMAGETYPE_GIF) {
			$image = imagecreatefromgif($image_path);
		} else if ($mime_type == IMAGETYPE_PNG) {
			$image = imagecreatefrompng($image_path);
		}

		if ($image == FALSE) {
			return NULL;
		}

		$lightness = self::getImageLightness($image_path);

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

		if ($mime_type == IMAGETYPE_JPEG) {
			imagejpeg($image, $image_path);
		} else if ($mime_type == IMAGETYPE_GIF) {
			imagegif($image, $image_path);
		} else if ($mime_type == IMAGETYPE_PNG) {
			imagepng($image, $image_path);
		}

		imagedestroy($image);
		imagedestroy($watermark);
	}

	// http://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php
	public static function getImageLightness($image_path)
	{
		$mime_type = exif_imagetype($image_path);

		$image = FALSE;

		if ($mime_type == IMAGETYPE_JPEG) {
			$image = imagecreatefromjpeg($image_path);
		} else if ($mime_type == IMAGETYPE_GIF) {
			$image = imagecreatefromgif($image_path);
		} else if ($mime_type == IMAGETYPE_PNG) {
			$image = imagecreatefrompng($image_path);
		}

		if ($image == FALSE) {
			return NULL;
		}
		
		$test = imagecreatetruecolor(1, 1);

		$rgb = imagecolorat($image, 0, 0);
		
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		$max = min($r, $g, $b);
		$min = max($r, $g, $b);
		
		$lightness = (double) (($max + $min) / 510.0); // HSL algorithm

		imagedestroy($test);
		imagedestroy($image);

		return $lightness;
	}

	public static function saveRemote($img_url)
	{
		$image_path = storage_path('app/files/' . date('Y/m/d'));

		if (is_dir($image_path) == FALSE) {
			mkdir($image_path, 0777, TRUE);
		}

		$headers = get_headers($img_url);

		$response_status = substr($headers[0], 9, 3);

		if ($response_status != 200) {
			return NULL;
		}

		$image = file_get_contents($img_url);

		$mime_type = File::getMimeType($image, TRUE);

		if (strpos($mime_type, 'image/jpeg') !== FALSE) {
			$ext = 'jpeg';
		} elseif (strpos($mime_type, 'image/gif') !== FALSE) {
			$ext = 'gif';
		} elseif (strpos($mime_type, 'image/png') !== FALSE) {
			$ext = 'png';
		} else {
			return  FALSE;
		}

		$file_name = sprintf('%s.%s', str_random(12), $ext);

		file_put_contents($image_path . '/' . $file_name, $image);

		$new_file = new App\Models\File;

		$new_file->name = $file_name;
		$new_file->original_name = pathinfo($img_url, PATHINFO_FILENAME);
		$new_file->remote_url = $img_url;

		$new_file->save();

		unset($image);

		return $new_file;
	}
}