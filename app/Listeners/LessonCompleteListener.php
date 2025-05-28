<?php

namespace App\Listeners;

use App\Events\LessonComplete;
use App\Events\SectionComplete;
use App\Events\SectionUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class LessonCompleteListener
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
    public function handle(LessonComplete $event): void
    {
        $email_on_event = $event->lesson->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }

        $section = $event->lesson->section;

        $section_progress = $section->calcSectionProgress($event->user->id);
        $event->user->addProgress($section_progress, $section);
        event(new SectionUpdate($section, $event->user, $section_progress));

        if ($event->user->isProgressCompleted($section_progress)) {
            event(new SectionComplete($section, $event->user));
        }
    }
}
