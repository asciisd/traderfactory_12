<?php

namespace App\Traits;

use App\Models\Progress;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait Progressive
{
    /**
     * Add deleted observer to delete favorites registers
     */
    public static function bootProgressive(): void
    {
        static::deleted(
            function ($model) {
                $model->progresses()->delete();
            }
        );
    }

    public function progresses(): MorphMany
    {
        return $this->morphMany(Progress::class, 'progressive');
    }

    public function addProgress($progress, ?int $user_id = null): bool
    {
        $user = $user_id ?? auth()->id();
        $current = $this->progresses()->firstOrCreate([
            'user_id' => $user,
            'progressive_type' => get_class($this),
            'progressive_id' => $this->id,
        ], ['progress_value' => $progress]);

        return $current->update(['progress_value' => $progress]);
    }

    public function userProgress(?int $user_id = null): Progress
    {
        return new Progress(['user_id' => $user_id ?? auth()->id()]);
    }

    public function getUserProgressAttribute(?int $user_id = null)
    {
        return $this->progresses()
            ->where('user_id', ($user_id) ?: auth()->id())
            ->first()?->progress_value ?? 0.0;
    }

    public function getProgress(?int $user_id = null)
    {
        return $this->progresses()
            ->where('user_id', ($user_id) ?: auth()->id())
            ->first()?->progress_value ?? 0.0;
    }

    public function removeProgress(?int $user_id = null): void
    {
        $this->progresses()
            ->where('user_id', $user_id ?? auth()->id())
            ->delete();
    }

    public function isProgressed(?int $user_id = null): bool
    {
        return $this->progresses()
            ->where('user_id', $user_id ?? auth()->id())
            ->exists();
    }

    public function progressedBy(): Collection
    {
        return $this->progresses()
            ->with('user')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['user']->id => $item['user']];
            });
    }

    public function getProgressesCountAttribute(): int
    {
        return $this->progresses()->count();
    }

    public function progressesCount()
    {
        return $this->progresses_count;
    }
}
