<?php

namespace App\Listeners;

use App\Events\MagazineUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class MagazineUpdateListener
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
    public function handle(MagazineUpdate $event): void
    {
        $email_on_event = $event->magazine->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
