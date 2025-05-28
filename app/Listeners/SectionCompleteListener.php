<?php

namespace App\Listeners;

use App\Events\SectionComplete;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class SectionCompleteListener
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
    public function handle(SectionComplete $event): void
    {
        $email_on_event = $event->section->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
