<?php

namespace App\Models;

use App\Contracts\ProgressiveInterface;
use App\Contracts\EventableInterface;
use App\Http\Resources\MagazineResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Nagy\LaravelRating\Traits\Rateable;

class Magazine extends Model implements ProgressiveInterface, EventableInterface
{
    /** @use HasFactory<\Database\Factories\MagazineFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = ['title', 'slug', 'duration'];

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

    public function section(): HasOneThrough
    {
        return $this->hasOneThrough(Section::class, Lesson::class, 'id', 'id', 'lesson_id', 'section_id');
    }

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class);
    }

    public function asResource()
    {
        return MagazineResource::make($this->fresh());
    }

    public function ratesRoute(): string
    {
        return route('magazines.rates', $this);
    }
}
