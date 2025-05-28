<?php

namespace App\Listeners;

use App\Events\EventableComplete;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class EventableCompleteListener
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
    public function handle(EventableComplete $event): void
    {
        $this->sendEmail($event);
    }

    /**
     * Send email notification if applicable.
     */
    protected function sendEmail(EventableComplete $event): void
    {
        $email_on_event = $event->eventable->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
