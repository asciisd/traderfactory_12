<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\RevisionResource;
use App\Models\Lesson;
use App\Models\Revision;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RevisionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Revision $revision)
    {
        // return RevisionResource::make($revision->load('revisionItems'));
        return Inertia::render('revision/Show', [
            'revision' => RevisionResource::make($revision->load('revisionItems')),
            'lesson' => LessonResource::make($revision->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Revision $revision)
    {
        if ($request->user()->isProgressStarted($revision)) {
            event(new EventableStart($revision, $request->user()));

            if ($request->user()->isProgressStarted($revision->lesson)) {
                event(new EventableStart($revision->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($revision->section)) {
                event(new EventableStart($revision->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $revision);
        event(new EventableUpdate($revision, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($revision, $request->user()));

            $this->updateLessonProgress($request->user(), $revision->lesson);
            $this->updateSectionProgress($request->user(), $revision->section);
        }

        return redirect()->back()->with('progress', [
            'model' => RevisionResource::make($revision),
            'href' => route('revisions.rates', $revision),
        ]);
    }

    public function updateFavorites(Request $request, Revision $revision)
    {
        $request->user()->toggleFavorite($revision);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Revision $revision)
    {
        $request->user()->rate($revision, $request->rate);

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