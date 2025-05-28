<?php

namespace App\Listeners;

use App\Events\TodoStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class TodoStartListener
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
    public function handle(TodoStart $event): void
    {
        $email_on_event = $event->todo->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
