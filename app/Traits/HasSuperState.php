<?php

namespace App\Traits;

trait HasSuperState
{
    public function isSuper(): bool
    {
        return $this->is_super ?? false;
    }

    public function makeSuper(bool $value): void
    {
        $this->forceFill([
            'is_super' => $value,
        ])->save();
    }

    public function isSuperAdmin(): bool
    {
        return $this->isSuper();
    }
}
