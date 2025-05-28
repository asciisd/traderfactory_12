<?php

namespace App\Listeners;

use App\Events\SectionStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class SectionStartListener
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
    public function handle(SectionStart $event): void
    {
        $email_on_event = $event->section->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
