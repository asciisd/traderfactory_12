<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\RevisionResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Nagy\LaravelRating\Traits\Rateable;

class Revision extends Model implements EventableInterface, ProgressiveInterface
{
    /** @use HasFactory<\Database\Factories\RevisionFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = ['title', 'slug', 'duration', 'background_url'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function revisionItems(): HasMany
    {
        return $this->hasMany(RevisionItem::class);
    }

    public function section(): HasOneThrough
    {
        return $this->hasOneThrough(Section::class, Lesson::class, 'id', 'id', 'lesson_id', 'section_id');
    }

    public function asResource()
    {
        return RevisionResource::make($this->refresh());
    }

    public function ratesRoute(): string
    {
        return route('revisions.rates', $this);
    }
}
