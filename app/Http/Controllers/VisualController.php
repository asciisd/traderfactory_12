<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\VisualResource;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use App\Models\Visual;
use App\Policies\Policy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisualController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Visual $visual)
    {
        // $this->authorize(Policy::View, $visual);

        return Inertia::render('visual/Show', [
            'visual' => VisualResource::make($visual),
            'lesson' => LessonResource::make($visual->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Visual $visual)
    {
        if ($request->user()->isProgressStarted($visual)) {
            event(new EventableStart($visual, $request->user()));

            if ($request->user()->isProgressStarted($visual->lesson)) {
                event(new EventableStart($visual->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($visual->section)) {
                event(new EventableStart($visual->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $visual);
        event(new EventableUpdate($visual, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($visual, $request->user()));

            $this->updateLessonProgress($request->user(), $visual->lesson);
            $this->updateSectionProgress($request->user(), $visual->section);
        }

        return redirect()->back()->with('progress', [
            'model' => VisualResource::make($visual),
            'href' => route('visuals.rates', $visual),
        ]);
    }

    public function updateFavorites(Request $request, Visual $visual)
    {
        $request->user()->toggleFavorite($visual);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Visual $visual)
    {
        $request->user()->rate($visual, $request->rate);

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
