<?php

namespace App\Listeners;

use App\Events\RevisionStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class RevisionStartListener
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
    public function handle(RevisionStart $event): void
    {
        $email_on_event = $event->revision->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
