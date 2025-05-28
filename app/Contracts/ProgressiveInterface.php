<?php

namespace App\Contracts;

use App\Models\Progress;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface ProgressiveInterface
{
    public static function bootProgressive();

    public function progresses(): MorphMany;

    public function addProgress($progress, ?int $user_id = null): bool;

    public function userProgress(?int $user_id = null): Progress;

    public function getUserProgressAttribute(?int $user_id = null);

    public function getProgress(?int $user_id = null);

    public function removeProgress(?int $user_id = null): void;

    public function isProgressed(?int $user_id = null): bool;

    public function progressedBy(): Collection;

    public function getProgressesCountAttribute(): int;

    public function progressesCount();
}
