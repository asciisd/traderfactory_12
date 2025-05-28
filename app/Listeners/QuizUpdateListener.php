<?php

namespace App\Listeners;

use App\Events\QuizUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class QuizUpdateListener
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
    public function handle(QuizUpdate $event): void
    {
        $email_on_event = $event->quiz->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
