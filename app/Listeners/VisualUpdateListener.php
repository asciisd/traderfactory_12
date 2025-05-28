<?php

namespace App\Listeners;

use App\Events\VisualUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class VisualUpdateListener
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
    public function handle(VisualUpdate $event): void
    {
        $email_on_event = $event->visual->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
