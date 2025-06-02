<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function updateFavorites(Request $request, Section $section)
    {
        $request->user()->toggleFavorite($section);

        return redirect()->back();
    }
}
