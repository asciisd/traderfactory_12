<?php

namespace App\Traits;

use App\Enums\EventableEvent;
use App\Models\EmailOnEvent;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasEmailOnEvents
{
    /**
     * Get all the events for the goal.
     */
    public function emailOnEvents(): MorphMany
    {
        return $this->morphMany(EmailOnEvent::class, 'eventable');
    }

    public function emailOnEventStart(): EmailOnEvent|MorphMany|null
    {
        return $this->emailOnEvents()->where('event', EventableEvent::OnStart)->latest()->first();
    }

    public function emailOnEventComplete(): EmailOnEvent|MorphMany|null
    {
        return $this->emailOnEvents()->where('event', EventableEvent::OnComplete)->latest()->first();
    }

    public function emailOnEventUpdate(): EmailOnEvent|MorphMany|null
    {
        return $this->emailOnEvents()->where('event', EventableEvent::OnUpdate)->latest()->first();
    }
}
