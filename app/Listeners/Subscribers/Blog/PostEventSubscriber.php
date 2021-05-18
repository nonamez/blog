<?php

namespace App\Listeners\Subscribers\Blog;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events;

class PostEventSubscriber
{
    public function onPostTranslatedDeleting(Events\Blog\Post\Translated\Deleting $event)
    {
        foreach ($event->post->files as $file) {
            $file->delete();
        }
    }

    public function onPostDeleting(Events\Blog\Post\Deleting $event)
    {
        foreach ($event->post->translations as $translated) {
            foreach ($translated->files as $file) {
                $file->delete();
            }
        }
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Blog\Post\Translated\Deleting',
            [PostEventSubscriber::class, 'onPostTranslatedDeleting']
        );

        $events->listen(
            'App\Events\Blog\Post\Deleting',
            [PostEventSubscriber::class, 'onPostDeleting']
        );
    }
}
