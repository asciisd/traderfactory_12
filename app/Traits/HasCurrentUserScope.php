<?php

namespace App\Traits;

use App\Models\Scopes\CurrentUserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait HasCurrentUserScope
{
    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentUserScope);

        if (! auth('admin')->hasUser()) {
            static::creating(function ($model) {
                if (Schema::hasColumn($model->getTable(), 'user_id')) {
                    if (empty($model->user_id)) {
                        $model->user_id = auth()->id();
                    }
                }
            });
        }
    }

    public static function unrestricted(): static|Builder
    {
        return static::withoutGlobalScope(CurrentUserScope::class);
    }
}
