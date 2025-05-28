<?php

namespace App\Listeners;

use App\Events\LessonComplete;
use App\Events\LessonUpdate;
use App\Events\TodoComplete;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class TodoCompleteListener
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
    public function handle(TodoComplete $event): void
    {
        $email_on_event = $event->todo->emailOnEventComplete();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }

        $lesson = $event->todo->lesson;

        $lesson_progress = $lesson->calcLessonProgress($event->user->id);
        $event->user->addProgress($lesson_progress, $lesson);
        event(new LessonUpdate($lesson, $event->user, $lesson_progress));

        if ($event->user->isProgressCompleted($lesson_progress)) {
            event(new LessonComplete($lesson, $event->user));
        }
    }
}
