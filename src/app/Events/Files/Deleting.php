<?php

namespace App\Events\Files;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models;

class Deleting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $file;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Models\Files\File $file)
    {
        $this->file = $file;
    }
}
