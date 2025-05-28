<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\SectionResource;
use App\Traits\Favorable;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Nagy\LaravelRating\Traits\Rateable;

class Section extends Model implements EventableInterface, ProgressiveInterface
{
    /** @use HasFactory<\Database\Factories\SectionFactory> */
    use HasFactory;
    use Favorable, HasEmailOnEvents, Progressive;
    use Rateable;

    protected $appends = ['user_progress'];

    protected $fillable = [
        'title', 'name', 'description', 'overview', 'slug',
        'video_src', 'video_type', 'video_poster', 'background_src', 'color', 'duration', 'image_alt',
        'seo_title', 'meta_title', 'meta_image', 'meta_description', 'meta_keywords',
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function goals(): HasManyThrough
    {
        return $this->hasManyThrough(Goal::class, Lesson::class);
    }

    public function magazines(): HasManyThrough
    {
        return $this->hasManyThrough(Magazine::class, Lesson::class);
    }

    public function quickScans(): HasManyThrough
    {
        return $this->hasManyThrough(QuickScan::class, Lesson::class);
    }

    public function quizzes(): HasManyThrough
    {
        return $this->hasManyThrough(Quiz::class, Lesson::class);
    }

    public function revisions(): HasManyThrough
    {
        return $this->hasManyThrough(Revision::class, Lesson::class);
    }

    public function todos(): HasManyThrough
    {
        return $this->hasManyThrough(Todo::class, Lesson::class);
    }

    public function visuals(): HasManyThrough
    {
        return $this->hasManyThrough(Visual::class, Lesson::class);
    }

    public function lessonProgressPercentage($user_id): float|int
    {
        return $this->lessonsProgressFor($user_id) / ($this->lessons()->count() * 100);
    }

    public function lessonsProgressFor($user_id)
    {
        return Progress::where('progressive_type', Lesson::class)
            ->where('user_id', $user_id)
            ->whereIn('progressive_id', $this->lessons->pluck('id'))
            ->sum('progress_value');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function calcSectionProgress(int $user_id): float|int
    {
        $lessonsProgress = $this->lessons()->get()->map(function ($lesson) use ($user_id) {
            return $lesson->calcLessonProgress($user_id);
        });

        return $lessonsProgress->sum() / $lessonsProgress->count();
    }

    public function asResource()
    {
        return SectionResource::make($this->refresh());
    }
}
