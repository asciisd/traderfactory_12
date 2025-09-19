<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'orders' => OrderResource::collection(
                Order::latest()->with('orderable')->get()
            ),
        ]);
    }
}
