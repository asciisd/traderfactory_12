<?php

namespace App\Listeners;

use App\Events\SectionUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class SectionUpdateListener
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
    public function handle(SectionUpdate $event): void
    {
        $email_on_event = $event->section->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
