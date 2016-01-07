<?php
namespace App\Helpers\Site;

class Blog
{
	public static function postColor($type)
	{
		switch ($type) {
			case 'draft':
				$class = ' alert-warning';
				break;

			case 'hidden':
				$class = ' alert-danger';
				break;
			
			default:
				$class = '';
				break;
		}

		return $class;
	}
}