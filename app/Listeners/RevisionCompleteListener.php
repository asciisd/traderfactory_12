<?php

namespace App\Listeners;

use App\Events\LessonComplete;
use App\Events\LessonUpdate;
use App\Events\RevisionComplete;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class RevisionCompleteListener
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
    public function handle(RevisionComplete $event): void
    {
        $email_on_event = $event->revision->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }

        $lesson = $event->revision->lesson;

        $lesson_progress = $lesson->calcLessonProgress($event->user->id);
        $event->user->addProgress($lesson_progress, $lesson);
        event(new LessonUpdate($lesson, $event->user, $lesson_progress));

        if ($event->user->isProgressCompleted($lesson_progress)) {
            event(new LessonComplete($lesson, $event->user));
        }
    }
}
