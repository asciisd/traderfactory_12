<?php

namespace App\Events;

use App\Contracts\EventableInterface;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventableStart
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public EventableInterface $eventable, public User $user)
    {
        //
    }
}
