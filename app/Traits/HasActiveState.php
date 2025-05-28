<?php

namespace App\Traits;

trait HasActiveState
{
    public function isActive(): bool
    {
        return ! is_null($this->activated_at);
    }

    public function activate(): void
    {
        $this->forceFill([
            'activated_at' => now(),
        ])->save();
    }

    public function deactivate(): void
    {
        $this->forceFill([
            'activated_at' => null,
        ])->save();
    }

    public function getIsActiveAttribute(): bool
    {
        return ! is_null($this->activated_at);
    }
}
