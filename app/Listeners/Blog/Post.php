<?php

namespace App\Listeners\Blog;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events;

class Post
{
	public function onPostTranslatedDeleting(Events\Blog\Post\Translated\Deleting $event)
	{
		foreach ($event->post->files as $file) {
			$file->delete();
		}
	}

	public function onPostDeleting(Events\Blog\Post\Deleting $event)
	{
		foreach ($event->post->translated as $translated) {
			foreach ($translated->files as $file) {
				$file->delete();
			}
		}
	}

	public function subscribe($events)
	{
		$events->listen(
			'App\Events\Blog\Post\Translated\Deleting',
			'App\Listeners\Blog\Post@onPostTranslatedDeleting'
		);

		$events->listen(
			'App\Events\Blog\Post\Deleting',
			'App\Listeners\Blog\Post@onPostDeleting'
		);
	}
}
