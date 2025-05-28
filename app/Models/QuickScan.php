<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\QuickScanResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Nagy\LaravelRating\Traits\Rateable;

class QuickScan extends Model implements EventableInterface, ProgressiveInterface
{
    /** @use HasFactory<\Database\Factories\QuickScanFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = [
        'title', 'duration', 'quantity', 'rating', 'background_url', 'slug',
    ];

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

    public function quickQuestions(): HasMany
    {
        return $this->hasMany(QuickQuestion::class);
    }

    public function section(): HasOneThrough
    {
        return $this->hasOneThrough(Section::class, Lesson::class, 'id', 'id', 'lesson_id', 'section_id');
    }

    public function asResource()
    {
        return QuickScanResource::make($this->refresh());
    }

    public function ratesRoute(): string
    {
        return route('quickScans.rates', $this);
    }
}
