<?php

/**
 * Display different messages from session
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
 * Prepare post content
 */

if (function_exists('prepareContent') == FALSE) {
	function prepareContent($markdown)
	{
		$markdown_parser = new App\Misc\Post\MarkdownParser();

		$content = $markdown_parser->text($markdown);

		return $content;
	}
}