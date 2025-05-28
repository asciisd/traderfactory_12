<?php

namespace App\Listeners;

use App\Events\RevisionUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class RevisionUpdateListener
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
    public function handle(RevisionUpdate $event): void
    {
        $email_on_event = $event->revision->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
