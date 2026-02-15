<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\QuizResource;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\User;
use App\Policies\Policy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        // $this->authorize(Policy::View, $quiz);

        return Inertia::render('quiz/Show', [
            'quiz' => QuizResource::make($quiz),
            'lesson' => LessonResource::make($quiz->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Quiz $quiz)
    {
        if ($request->user()->isProgressStarted($quiz)) {
            event(new EventableStart($quiz, $request->user()));

            if ($request->user()->isProgressStarted($quiz->lesson)) {
                event(new EventableStart($quiz->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($quiz->section)) {
                event(new EventableStart($quiz->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $quiz);
        event(new EventableUpdate($quiz, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($quiz, $request->user()));

            $this->updateLessonProgress($request->user(), $quiz->lesson);
            $this->updateSectionProgress($request->user(), $quiz->section);
        }

        return redirect()->back()->with('progress', [
            'model' => QuizResource::make($quiz),
            'href' => route('quizzes.rates', $quiz),
        ]);
    }

    public function updateFavorites(Request $request, Quiz $quiz)
    {
        $request->user()->toggleFavorite($quiz);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Quiz $quiz)
    {
        $request->user()->rate($quiz, $request->rate);

        return redirect()->back();
    }

    /**
     * Update lesson progress and trigger related events.
     */
    protected function updateLessonProgress(User $user, Lesson $lesson): void
    {
        $lesson_progress = $lesson->calcLessonProgress($user->id);
        $user->addProgress($lesson_progress, $lesson);

        event(new EventableUpdate($lesson, $user, $lesson_progress));

        if ($user->isProgressCompleted($lesson_progress)) {
            event(new EventableComplete($lesson, $user));
        }
    }

    /**
     * Update section progress and trigger related events.
     */
    protected function updateSectionProgress(User $user, Section $section): void
    {
        $section_progress = $section->calcSectionProgress($user->id);
        $user->addProgress($section_progress, $section);

        event(new EventableUpdate($section, $user, $section_progress));

        if ($user->isProgressCompleted($section_progress)) {
            event(new EventableComplete($section, $user));
        }
    }
}