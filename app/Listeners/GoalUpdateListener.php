<?php

namespace App\Listeners;

use App\Events\GoalUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class GoalUpdateListener
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
    public function handle(GoalUpdate $event): void
    {
        $email_on_event = $event->goal->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
