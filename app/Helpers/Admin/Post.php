<?php

namespace App\Helpers\Admin;

use App\Models\Blog;
use App\Models\File as FileModel;

class Post
{
	// Attach tags to the post
	public static function tags(array $data, & $post)
	{
		$new_tags = [];

		if (array_key_exists('titles', $data) && array_key_exists('slugs', $data)) {
			foreach ($data['titles'] as $key => $name) {
				if (array_key_exists($key, $data['slugs']))
					$slug = strtolower($data['slugs'][$key]);
				else
					$slug = strtolower(str_replace(' ', '_', $name));
				
				$tag = Blog\Tag::firstOrCreate(['slug' => $slug, 'name' => $name]);
				
				array_push($new_tags, $tag->id);
			}
		}

		if (isset($data['ids']))
			$new_tags = array_merge($new_tags, $data['ids']);
		
		$post->tags()->sync($new_tags);
	}
}