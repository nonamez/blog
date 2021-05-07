<?php

namespace App\Listeners\Files;

use App\Events\Files\Deleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteStoredFile
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FilesDeleting  $event
     * @return void
     */
    public function handle(Deleting $event)
    {
        \Illuminate\Support\Facades\File::delete($event->file->getPath());
    }
}
