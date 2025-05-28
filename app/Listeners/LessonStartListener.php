<?php

namespace App\Listeners;

use App\Events\LessonStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class LessonStartListener
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
    public function handle(LessonStart $event): void
    {
        $email_on_event = $event->lesson->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
