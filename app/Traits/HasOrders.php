<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasOrders
{
    public function orderTitle(): string
    {
        return $this->hasAttribute('title') ? $this->title : $this->name;
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    /**
     * Check if the course is owned by the authed user.
     */
    public function purchased(): bool
    {
        return $this->orders()->where([
            'status' => 'SUCCESS',
            'user_id' => auth()->id(),
            'orderable_type' => self::class,
            'orderable_id' => $this->id,
        ])->count();
    }
}
