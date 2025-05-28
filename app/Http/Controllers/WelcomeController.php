<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\MetaData;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'metadata' => MetaData::where('page_slug', '/')->first(),
        ]);
    }

    public function about()
    {
        return Inertia::render('about/Index');
    }
}
