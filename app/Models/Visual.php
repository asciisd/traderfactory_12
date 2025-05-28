<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\VisualResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Nagy\LaravelRating\Traits\Rateable;

class Visual extends Model implements EventableInterface, ProgressiveInterface
{
    /** @use HasFactory<\Database\Factories\VisualFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = [
        'title', 'slug', 'description', 'duration', 'duration_seconds', 'video_url', 'video_poster', 'video_type',
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

    public function getVisualPath(): string
    {
        return $this->video_url->path;
    }

    public function section(): HasOneThrough
    {
        return $this->hasOneThrough(Section::class, Lesson::class, 'id', 'id', 'lesson_id', 'section_id');
    }

    public function asResource()
    {
        return VisualResource::make($this->refresh());
    }

    public function ratesRoute(): string
    {
        return route('visuals.rates', $this);
    }

    public function addProgress($progress, ?int $user_id = null): bool
    {
        // Video is considered watched if the user has watched 95% of it
        if ($progress >= 95) {
            $progress = 100;
        }

        $user = $user_id ?? auth()->id();
        $current = $this->progresses()->firstOrCreate([
            'user_id' => $user,
            'progressive_type' => get_class($this),
            'progressive_id' => $this->id,
        ], ['progress_value' => $progress]);

        return $current->update(['progress_value' => $progress]);
    }
}
