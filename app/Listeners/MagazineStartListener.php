<?php

namespace App\Listeners;

use App\Events\MagazineStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class MagazineStartListener
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
    public function handle(MagazineStart $event): void
    {
        $email_on_event = $event->magazine->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
