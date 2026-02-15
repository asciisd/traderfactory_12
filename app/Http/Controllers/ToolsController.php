<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ToolsController extends MasterController
{
    public function index(): InertiaResponse
    {
        return Inertia::render('tools/Index');
    }

    public function positionSize(): InertiaResponse
    {
        return Inertia::render('tools/position-size/Index');
    }

    public function pipValue(): InertiaResponse
    {
        return Inertia::render('tools/pip-value/Index');
    }

    public function marginCalculator(): InertiaResponse
    {
        return Inertia::render('tools/margin-calculator/Index');
    }
}