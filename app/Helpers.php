<?php

/**
 * Display different messages depending on session
 */

if (function_exists('displayAlert') == FALSE) {
	function displayAlert()
	{
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

/**
 * Get file mime type
 */

if (function_exists('prepareContent') == FALSE) {
	function prepareContent($markdown)
	{
		$markdown_parser = new App\Misc\Post\MarkdownParser();

		$content = $markdown_parser->text($markdown);

		return $content;
	}
}

/**
 * Get file mime type
 */

if (function_exists('getRandomCatImageURL') == FALSE) {
	function getRandomCatImageURL()
	{
		$files = glob(storage_path('app/public/cats/*.*'));

		// dd(exif_read_data('/var/www/html/NoNameZ/storage/app/public/cats/pukis_selfie.jpg'));

		// dd($files);

		shuffle($files);

		foreach ($files as $file) {
			if (exif_imagetype($file)) {
				return url('/storage/cats/'. basename($file));
			}
		}

		return FALSE;
	}
}
