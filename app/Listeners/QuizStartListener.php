<?php

namespace App\Listeners;

use App\Events\QuizStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class QuizStartListener
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
    public function handle(QuizStart $event): void
    {
        $email_on_event = $event->quiz->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
