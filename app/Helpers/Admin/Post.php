<?php

namespace App\Helpers\Admin;

use App\Models\Blog;

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
					$slug = strtolower($name);
				
				$tag = Blog\Tag::firstOrCreate(['slug' => $slug, 'name' => $name]);
				
				array_push($new_tags, $tag->id);
			}
		}

		if (isset($data['ids']))
			$new_tags = array_merge($new_tags, $data['ids']);
		
		$post->tags()->sync($new_tags);
	}

	// Attach files to current post
	public static function files(array $files, $post_id)
	{
		if (count($files) > 0)
			Blog\File::whereIn('id', $files)->update(['post_id' => $post_id]);
	}
}