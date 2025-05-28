<?php

namespace App\Contracts;

use App\Models\EmailOnEvent;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface EventableInterface
{
    public function emailOnEvents(): MorphMany;

    public function emailOnEventStart(): EmailOnEvent|MorphMany|null;

    public function emailOnEventComplete(): EmailOnEvent|MorphMany|null;

    public function emailOnEventUpdate(): EmailOnEvent|MorphMany|null;
}
