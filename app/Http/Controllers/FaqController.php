<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class FaqController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('faqs', function($q) {
            $q->where('is_active', true);
        })
        ->with(['faqs' => function($q) {
            $q->where('is_active', true)
            ->orderBy('order', 'asc');
        }])
        ->get();

        return response()->json($categories);
    }
}
