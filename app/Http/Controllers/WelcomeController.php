<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Faq;
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

    public function faq()
    {
        return Inertia::render('faqs/Index', [
            'faqs' => Faq::query()
                ->where(function ($q) {
                    $q->where('is_published', true)
                      ->orWhereNull('is_published');
                })
                ->orderBy('order_column')
                ->get(['id','question','answer'])
        ]);
    }

    public function webinars()
    {
        return Inertia::render('webinars/Index', [
            'webinars' => [],
        ]);
    }

    public function books()
    {
        return Inertia::render('books/Index', [
            'books' => BookResource::collection(Book::all()),
        ]);
    }
}