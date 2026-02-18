<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\TodoResource;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        // return  TodoResource::make($todo);
        return Inertia::render('todo/Show', [
            'todo' => TodoResource::make($todo),
            'lesson' => LessonResource::make($todo->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Todo $todo)
    {
        if ($request->user()->isProgressStarted($todo)) {
            event(new EventableStart($todo, $request->user()));

            if ($request->user()->isProgressStarted($todo->lesson)) {
                event(new EventableStart($todo->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($todo->section)) {
                event(new EventableStart($todo->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $todo);
        event(new EventableUpdate($todo, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($todo, $request->user()));

            $this->updateLessonProgress($request->user(), $todo->lesson);
            $this->updateSectionProgress($request->user(), $todo->section);
        }

        return redirect()->back()->with('progress', [
            'model' => TodoResource::make($todo),
            'href' => route('todos.rates', $todo),
        ]);
    }

    public function updateFavorites(Request $request, Todo $todo)
    {
        $request->user()->toggleFavorite($todo);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Todo $todo)
    {
        $request->user()->rate($todo, $request->rate);

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
