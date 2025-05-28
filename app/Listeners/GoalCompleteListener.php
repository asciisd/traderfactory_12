<?php

namespace App\Listeners;

use App\Events\GoalComplete;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class GoalCompleteListener
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
    public function handle(GoalComplete $event): void
    {
        $this->sendEmail($event);
    }

    /**
     * Send email notification if applicable.
     */
    protected function sendEmail(GoalComplete $event): void
    {
        $email_on_event = $event->goal->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
