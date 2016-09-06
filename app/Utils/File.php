<?php

namespace App\Utils;

class File
{
	public static function addWatermarkRepeatedly(\Illuminate\Http\UploadedFile & $file)
	{
		$mime_type = $file->getMimeType();
		$real_path = $file->getRealPath();

		if ($mime_type == 'image/jpeg')
			$image = imagecreatefromjpeg($real_path);
		elseif ($mime_type == 'image/gif')
			$image = imagecreatefromgif($real_path);
		elseif ($mime_type == 'image/png')
			$image = imagecreatefrompng($real_path);

		$watermark = imagecreatefrompng(storage_path('app/watermark.png'));

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

		if ($mime_type == 'image/jpeg')
			imagejpeg($image, $real_path);
		elseif ($mime_type == 'image/gif')
			imagegif($image, $real_path);
		elseif ($mime_type == 'image/png')
			imagepng($image, $real_path);

		imagedestroy($image);
		imagedestroy($watermark);
	}
}