<?php

/*
 * Display different messages from session
 */

if (function_exists('displayAlert') == FALSE) {
	function displayAlert() {
		if (session()->has('message')) {
			list($type, $message) = explode('|', session()->get('message'));

			if ($type == 'error') {
				$type = 'danger';
			} elseif ($type == 'message') {
				$type = 'info';
			}

			return sprintf('<div class="alert alert-%s">%s</div>', $type, $message);
		}

		return '';
	}
}

/*
 * Translit russian chars
 */

if (function_exists('ru2lat') == FALSE) {
	function ru2lat($string) {
		$rus = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];
		$lat = ['A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya'];
    	
    	return str_replace($rus, $lat, $string);
	}
}

/*
 * Returs file type
 */
if (function_exists('getMimeType') == FALSE) {
	function getMimeType($file, $buffer = FALSE) {
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

/*
 * Shows raw dump
 */

if (function_exists('ddRaw') == FALSE) {
	function ddRaw(...$args) {
		array_map(function ($x) {
			var_dump($x);
		}, $args);
		
		die(1);
	}
}