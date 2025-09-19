<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\GoalResource;
use App\Http\Resources\LessonResource;
use App\Models\Goal;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class GoalController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        Gate::authorize('view', $goal);

        return Inertia::render('goals/Show', [
            'goal' => GoalResource::make($goal),
            'lesson' => LessonResource::make($goal->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Goal $goal)
    {
        if ($request->user()->isProgressStarted($goal)) {
            event(new EventableStart($goal, $request->user()));

            if ($request->user()->isProgressStarted($goal->lesson)) {
                event(new EventableStart($goal->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($goal->section)) {
                event(new EventableStart($goal->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $goal);
        event(new EventableUpdate($goal, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($goal, $request->user()));

            $this->updateLessonProgress($request->user(), $goal->lesson);
            $this->updateSectionProgress($request->user(), $goal->section);
        }

        return back()->with('progress', [
            'model' => $goal->asResource(),
            'href' => $goal->ratesRoute(),
        ]);
    }

    public function updateFavorites(Request $request, Goal $goal)
    {
        $request->user()->toggleFavorite($goal);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Goal $goal)
    {
        $request->user()->rate($goal, $request->rate);

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
