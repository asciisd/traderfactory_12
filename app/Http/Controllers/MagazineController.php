<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\MagazineResource;
use App\Models\Lesson;
use App\Models\Magazine;
use App\Models\Section;
use App\Models\User;
use App\Policies\Policy;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MagazineController extends Controller
{
    use AuthorizesRequests;

    public function show(Magazine $magazine)
    {
        // $this->authorize(Policy::View, $magazine);
        return Inertia::render('magazine/Show', [
            'magazine' => MagazineResource::make($magazine),
            'lesson' => LessonResource::make($magazine->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, Magazine $magazine)
    {
        if ($request->user()->isProgressStarted($magazine)) {
            event(new EventableStart($magazine, $request->user()));

            if ($request->user()->isProgressStarted($magazine->lesson)) {
                event(new EventableStart($magazine->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($magazine->section)) {
                event(new EventableStart($magazine->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $magazine);
        event(new EventableUpdate($magazine, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($magazine, $request->user()));

            $this->updateLessonProgress($request->user(), $magazine->lesson);
            $this->updateSectionProgress($request->user(), $magazine->section);
        }

        return redirect()->back()->with('progress', [
            'model' => MagazineResource::make($magazine),
            'href' => route('magazines.rates', $magazine),
        ]);
    }

    public function updateFavorites(Request $request, Magazine $magazine)
    {
        $request->user()->toggleFavorite($magazine);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, Magazine $magazine)
    {
        $request->user()->rate($magazine, $request->rate);

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