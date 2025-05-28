<?php

namespace App\Models;

use App\Contracts\EventableInterface;
use App\Contracts\ProgressiveInterface;
use App\Http\Resources\LessonResource;
use App\Traits\HasEmailOnEvents;
use App\Traits\Progressive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Nagy\LaravelRating\Traits\Rateable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Lesson extends Model implements EventableInterface, ProgressiveInterface, Sortable
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;
    use HasEmailOnEvents, Progressive;
    use Rateable, SortableTrait;

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
        'ignore_policies' => true,
        'sort_on_has_many' => true,
    ];

    protected $appends = ['user_progress'];

    protected $fillable = ['name', 'duration', 'slug'];

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

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function goal(): HasOne
    {
        return $this->hasOne(Goal::class);
    }

    public function magazine(): HasOne
    {
        return $this->hasOne(Magazine::class);
    }

    public function quickScan(): HasOne
    {
        return $this->hasOne(QuickScan::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function revision(): HasOne
    {
        return $this->hasOne(Revision::class);
    }

    public function todo(): HasOne
    {
        return $this->hasOne(Todo::class);
    }

    public function visual(): HasOne
    {
        return $this->hasOne(Visual::class);
    }

    public function calcLessonProgress($user_id): float|int
    {
        $count = 0;
        $totalProgress = 0;

        if ($this->goal) {
            $count++;
            $totalProgress = $this->goal?->getProgress($user_id);
        }

        if ($this->magazine) {
            $count++;
            $totalProgress += $this->magazine?->getProgress($user_id);
        }

        if ($this->todo) {
            $count++;
            $totalProgress += $this->todo?->getProgress($user_id);
        }

        if ($this->quiz) {
            $count++;
            $totalProgress += $this->quiz?->getProgress($user_id);
        }

        if ($this->revision) {
            $count++;
            $totalProgress += $this->revision?->getProgress($user_id);
        }

        if ($this->visual) {
            $count++;
            $totalProgress += $this->visual?->getProgress($user_id);
        }

        if ($this->quickScan) {
            $count++;
            $totalProgress += $this->quickScan?->getProgress($user_id);
        }

        return $totalProgress / $count;
    }

    public function asResource()
    {
        return LessonResource::make($this->refresh());
    }
}
