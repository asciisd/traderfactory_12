<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaqResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->with('category')->get();
        return inertia('faqs/Index', [
            'faqs' => FaqResource::collection($faqs)->resolve(),
        ]);
    }
}
