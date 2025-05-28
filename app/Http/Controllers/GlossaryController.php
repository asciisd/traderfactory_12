<?php

namespace App\Http\Controllers;

use App\Http\Resources\GlossaryResource;
use App\Models\Glossary;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Glossary::all();

        if ($request->query('s')) {
            $data = Glossary::where('title', 'like', "%{$request->query('s')}%")
                ->orWhere('title_ar', 'like', "%{$request->query('s')}%")
                ->get();
        }

        return inertia('glossary/Index', [
            'glossaries' => GlossaryResource::collection($data),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Glossary $glossary)
    {
        // Get all glossaries for navigation and related terms
        $allGlossaries = Glossary::all();

        return inertia('glossary/Show', [
            'glossary' => GlossaryResource::make($glossary),
            'allGlossaries' => GlossaryResource::collection($allGlossaries),
        ]);
    }
}
