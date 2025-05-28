<?php

namespace App\Models;

use App\Enums\EventableEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailOnEvent extends Model
{
    /** @use HasFactory<\Database\Factories\EmailOnEventFactory> */
    use HasFactory;

    protected $fillable = ['title', 'event', 'model', 'message', 'html'];

    protected function casts(): array
    {
        return [
            'event' => EventableEvent::class,
            'message' => 'json',
            'html' => 'json',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function scopeEventStart(Builder $query): Builder
    {
        return $query->where('event', 'Start');
    }

    public function scopeEventComplete(Builder $query): Builder
    {
        return $query->where('event', 'Complete');
    }

    public function scopeEventUpdate(Builder $query): Builder
    {
        return $query->where('event', 'Update');
    }

    public function scopeForModel(Builder $query, $model): Builder
    {
        return $query->where('model', $model);
    }

    /**
     * Get the parent eventable model (goal, magazine ...etc).
     */
    public function eventable(): MorphTo
    {
        return $this->morphTo();
    }
}
