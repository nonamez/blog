<?php
namespace App\Misc\Post;

// http://stackoverflow.com/questions/230270/php-syntax-highlighting/6358880#6358880
// http://phoboslab.org/log/2007/08/generic-syntax-highlighting-with-regular-expressions

// 	pre { 
// 	font-family: Droid Sans Mono, Courier New, Lucida Console, Bitstream Vera Sans Mono, monospace; 
// 	font-size: 12px;
// 	background-color: #fafafa;
// 	/*border-left: 5px solid #f6f6f6;*/
// 	padding: 1em 0 1em 1em;
// 	overflow: auto;
// 	color: #000;
// }

// 	pre span.N{ color:#ea0; } /* Numbers */
// 	pre span.S{ color:#080; } /* Strings */
// 	pre span.C{ color:#a60; } /* Comments */
// 	pre span.K{ color:#008; } /* Keywords */
// 	pre span.V{ color:#808; } /* Vars */
// 	pre span.D{ color:#a00; } /* Defines */

// 	pre span.N {color:#8CD0D3} /* Numbers */
// 	pre span.S {color:#CC9385} /* Strings */
// 	pre span.C {color:#7F9F7F} /* Comments */
// 	pre span.K {color:#DFC47D} /* Keywords */
// 	pre span.V {color:#CEDF99} /* Vars */
// 	pre span.D {color:#FFFFFF} /* Defines */
// 	pre span.P {color:#9F9D65} /* Punctuations */


class SyntaxHighlight
{
	public static function process($s)
	{
		$s = htmlspecialchars($s);
		
		// Workaround for escaped backslashes
		$s = str_replace('\\\\','\\\\<e>', $s); 
		
		$regexp = array(
			// Punctuations
			'/([\-\!\%\^\*\(\)\+\|\~\=\`\{\}\[\]\:\"\'<>\?\,\.\/]+)/'
			=> '<span class="P">$1</span>',

			// Numbers (also look for Hex)
			'/(?<!\w)(
				(0x|\#)[\da-f]+|
				\d+|
				\d+(px|em|cm|mm|rem|s|\%)
			)(?!\w)/ix'
			=> '<span class="N">$1</span>',

			// Make the bold assumption that an
			// all uppercase word has a special meaning
			'/(?<!\w|>|\#)(
				[A-Z_0-9]{2,}
			)(?!\w)/x'
			=> '<span class="D">$1</span>',

			// Keywords
			'/(?<!\w|\$|\%|\@|>)(
				and|or|xor|for|do|while|foreach|as|return|die|exit|if|then|else|
				elseif|new|delete|try|throw|catch|finally|class|function|string|
				array|object|resource|var|let|bool|boolean|int|integer|float|double|
				real|string|array|global|const|static|public|private|protected|
				published|extends|switch|true|false|null|void|this|self|struct|
				char|signed|unsigned|short|long
			)(?!\w|=")/ix'
			=> '<span class="K">$1</span>',

			// PHP/Perl-Style Vars: $var, %var, @var
			'/(?<!\w)(
				(\$|\%|\@)(\-&gt;|\w)+
			)(?!\w)/ix'
			=> '<span class="V">$1</span>'
		);

		// Comments/Strings
		$regexp_callable = 
			'/(
				\/\*.*?\*\/|
				\/\/.*?\n|
				\#.*?\n|
				(?<!\\\)&quot;.*?(?<!\\\)&quot;|
				(?<!\\\)\'(.*?)(?<!\\\)\'
			)/isx';
		
		$tokens = []; // This array will be filled from the regexp-callback

		$s = preg_replace_callback($regexp_callable, function($m) use(& $tokens) {
			return self::replaceId($tokens, $m[1]);
		}, $s);
		
		$s = preg_replace(array_keys($regexp), array_values($regexp), $s);
		
		// Paste the comments and strings back in again
		$s = str_replace(array_keys($tokens), array_values($tokens), $s);
		
		// Delete the "Escaped Backslash Workaround Token" (TM) and replace 
		// tabs with four spaces.
		$s = str_replace(array( '<e>', "\t"), array('', '    '), $s);
		
		return $s;
	}
	
	// Regexp-Callback to replace every comment or string with a uniqid and save 
	// the matched text in an array
	// This way, strings and comments will be stripped out and wont be processed 
	// by the other expressions searching for keywords etc.
	private static function replaceId(&$a, $match)
	{
		$id = "##r" . uniqid() . "##";
		
		// String or Comment?
		if ($match{0} == '/' || $match{0} == '#') {
			$a[$id] = '<span class="C">' . $match . '</span>';
		} else {
			$a[$id] = '<span class="S">' . $match . '</span>';
		}

		return $id;
	}
}