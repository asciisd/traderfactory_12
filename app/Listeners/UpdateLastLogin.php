<?php

namespace App\Listeners;

use App\Events\LastLogin;
use Carbon\Carbon;

class UpdateLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LastLogin $event): void
    {
        $event->user->update(['last_login_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
