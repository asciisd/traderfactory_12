<?php

namespace App\Listeners;

use App\Events\LessonUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class LessonUpdateListener
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
    public function handle(LessonUpdate $event): void
    {
        $email_on_event = $event->lesson->emailOnEventUpdate();

        $section = $event->lesson->section;
        $event->user->addProgress(
            $section->calcSectionProgress($event->user->id), $section
        );

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
