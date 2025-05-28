<?php

namespace App\Traits;

use App\Contracts\ProgressiveInterface;
use App\Models\Progress;

trait HasProgress
{
    public function progresses()
    {
        return $this->hasMany(Progress::class, 'user_id');
    }

    public function progress($class)
    {
        return $this->progresses()
            ->where('progressive_type', $class)
            ->with('progressive')
            ->get();
    }

    public function progressValue($class)
    {
        return $this->progress($class::class)->first()?->progress_value;
    }

    public function addProgress($progress, ProgressiveInterface $object)
    {
        $object->addProgress($progress, $this->id);
    }

    public function isProgressStarted(ProgressiveInterface $object): bool
    {
        return ! $this->isProgressed($object);
    }

    public function isProgressCompleted($user_progress): bool
    {
        return $user_progress >= 100;
    }

    public function removeProgress(ProgressiveInterface $object): void
    {
        $object->removeProgress($this->id);
    }

    public function isProgressed(ProgressiveInterface $object): bool
    {
        return $object->isProgressed($this->id);
    }

    public function hasProgresses(ProgressiveInterface $object)
    {
        return $object->isProgressed($this->id);
    }
}
