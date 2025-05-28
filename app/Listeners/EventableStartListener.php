<?php

namespace App\Listeners;

use App\Events\EventableStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class EventableStartListener
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
    public function handle(EventableStart $event): void
    {
        $email_on_event = $event->eventable->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
