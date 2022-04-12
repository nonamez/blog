<?php

namespace App\Listeners\Subscribers\Blog;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events;

class PostEventSubscriber
{
    public function onPostTranslatedDeleting(Events\Blog\Post\Translated\Deleting $event)
    {
        $name = 'header-tags-' . $event->post->locale;

        cache()->forget($name);

        foreach ($event->post->files as $file) {
            $file->delete();
        }
    }

    public function onPostDeleting(Events\Blog\Post\Deleting $event)
    {
        foreach (config('blog.locales') as $locale) {
            $name = 'header-tags-' . $locale;

            cache()->forget($name);
        }

        foreach ($event->post->translations as $translated) {
            foreach ($translated->files as $file) {
                $file->delete();
            }
        }
    }

    public function onPostTranslatedSaved(Events\Blog\Post\Translated\Saved $event)
    {
        $name = 'header-tags-' . $event->post->locale;

        cache()->forget($name);
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Blog\Post\Translated\Saved',
            [PostEventSubscriber::class, 'onPostTranslatedSaved']
        );

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
