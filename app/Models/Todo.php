<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\TodoResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Nagy\LaravelRating\Traits\Rateable;

class Todo extends Model implements EventableInterface, ProgressiveInterface
{
    /** @use HasFactory<\Database\Factories\TodoFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = [
        'title', 'slug', 'description', 'duration', 'background_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function section(): HasOneThrough
    {
        return $this->hasOneThrough(Section::class, Lesson::class, 'id', 'id', 'lesson_id', 'section_id');
    }

    public function asResource()
    {
        return TodoResource::make($this->refresh());
    }

    public function ratesRoute(): string
    {
        return route('todos.rates', $this);
    }
}
