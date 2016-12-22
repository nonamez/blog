<?php

namespace App\Misc\Post;

use Parsedown;

class MarkdownParser extends Parsedown
{
	protected function blockFencedCodeComplete($Block)
	{
		$text = $Block['element']['text']['text'];

		$text = SyntaxHighlight::process($text);

		$Block['element']['text']['text'] = $text;

		return $Block;
	}
}