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

if (function_exists('getMimeType') == FALSE) {
	function getMimeType($file) {
		if (function_exists('finfo_file')) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);

			$mime = finfo_file($finfo, $file);

			finfo_close($finfo);

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

/**
 * Get file mime type
 */

if (function_exists('prepareContent') == FALSE) {
	function prepareContent($markdown) {
		$environment = League\CommonMark\Environment::createCommonMarkEnvironment();
		$parser = new League\CommonMark\DocParser($environment);
		$htmlRenderer = new League\CommonMark\HtmlRenderer($environment);

		$document = $parser->parse($markdown);

		$walker = $document->walker();

		while ($event = $walker->next()) {
			if ($event->isEntering() && get_class($event->getNode()) == 'League\CommonMark\Block\Element\FencedCode') {
				$node = $event->getNode();

				dd($node->data);

				$code = $node->getStringContent();
				$code = App\Utils\SyntaxHighlight::process($code);

				dd(get_class_methods($node));
			}
		}


		$html =  $htmlRenderer->renderBlock($document);

		return $html;

		$converter = new League\CommonMark\CommonMarkConverter();

		$content = $converter->convertToHtml($content);

		return App\Utils\SyntaxHighlight::process($code);

		return $content;
	}
}