<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\SectionResource;
use App\Models\Course;
use App\Models\MetaData;
use App\Models\Section;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course): InertiaResponse
    {
        return Inertia::render('courses/Index', [
            'courses' => CourseResource::collection(Course::with('sections.lessons')->get()),
            'metadata' => MetaData::where('page_slug', 'courses')->first(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): InertiaResponse
    {
        return Inertia::render('courses/Show', [
            'course' => CourseResource::make($course),
            'metadata' => MetaData::where('page_slug', $course->slug)->first(),
        ]);
    }

    /**
     * Showing course section details
     */
    public function sections(Section $section): InertiaResponse
    {
        if (! $section->course->active || ($section->course->published_at->isFuture())) {
            abort(404);
        }

        return Inertia::render('sections/Index', [
            'section' => SectionResource::make($section),
            'favStatus' => auth()->check() ? auth()->user()->isFavorited($section) : null,
            'metadata' => MetaData::where('page_slug', $section->slug)->first(),
        ]);
    }
}