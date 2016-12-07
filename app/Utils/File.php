<?php

namespace App\Utils;

class File
{
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