<?php

namespace App\Http\Controllers;

use App\Events\EventableComplete;
use App\Events\EventableStart;
use App\Events\EventableUpdate;
use App\Http\Requests\ProgressRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\QuickScanResource;
use App\Models\Lesson;
use App\Models\QuickScan;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuickScanController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(QuickScan $quickScan)
    {
        // return QuickScanResource::make($quickScan);
        return Inertia::render('quick-scan/Show', [
            'quickScan' => QuickScanResource::make($quickScan->load('quickQuestions')),
            'lesson' => LessonResource::make($quickScan->lesson),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProgress(ProgressRequest $request, QuickScan $quickScan)
    {
        if ($request->user()->isProgressStarted($quickScan)) {
            event(new EventableStart($quickScan, $request->user()));

            if ($request->user()->isProgressStarted($quickScan->lesson)) {
                event(new EventableStart($quickScan->lesson, $request->user()));
            }

            if ($request->user()->isProgressStarted($quickScan->section)) {
                event(new EventableStart($quickScan->section, $request->user()));
            }
        }

        $request->user()->addProgress($request->user_progress, $quickScan);
        event(new EventableUpdate($quickScan, $request->user(), $request->user_progress));

        if ($request->user()->isProgressCompleted($request->user_progress)) {
            event(new EventableComplete($quickScan, $request->user()));

            $this->updateLessonProgress($request->user(), $quickScan->lesson);
            $this->updateSectionProgress($request->user(), $quickScan->section);
        }

        return redirect()->back()->with('progress', [
            'model' => QuickScanResource::make($quickScan),
            'href' => route('quickScans.rates', $quickScan),
        ]);
    }

    public function updateFavorites(Request $request, QuickScan $quickScan)
    {
        $request->user()->toggleFavorite($quickScan);

        return redirect()->back();
    }

    public function updateRate(RatingRequest $request, QuickScan $quickScan)
    {
        $request->user()->rate($quickScan, $request->rate);

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
