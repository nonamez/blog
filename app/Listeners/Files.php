<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events;

class Files
{
	public function onDeleting(Events\File\Deleting $event)
	{
		\Illuminate\Support\Facades\File::delete($event->file->getPath());
	}

	public function subscribe($events)
	{
		$events->listen(
			'App\Events\File\Deleting',
			'App\Listeners\Files@onDeleting'
		);
	}
}
