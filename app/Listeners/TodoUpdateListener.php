<?php

namespace App\Listeners;

use App\Events\TodoUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class TodoUpdateListener
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
    public function handle(TodoUpdate $event): void
    {
        $email_on_event = $event->todo->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
