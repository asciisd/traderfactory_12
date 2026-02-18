<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $courses_count = $user->orders()->where('orderable_type', 'App\Models\Course')->count();
        $books_count = $user->orders()->where('orderable_type', 'App\Models\Book')->count();
        $orders_count = $user->orders()->count();
        // dd($orders_count);

        return Inertia::render('Dashboard', [
            'orders' => OrderResource::collection(
                Order::latest()->with('orderable')->get()
            ),
            'courses_count' => $courses_count,
            'books_count' => $books_count,
            'orders_count' => $orders_count,

        ]);
    }
}