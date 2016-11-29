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