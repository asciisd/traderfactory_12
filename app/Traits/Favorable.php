<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait Favorable
{
    /**
     * Add deleted observer to delete favorites registers
     */
    public static function bootFavorable(): void
    {
        static::deleted(
            function ($model) {
                $model->favorites()->delete();
            }
        );
    }

    /**
     * Define a polymorphic one-to-many relationship.
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorable');
    }

    /**
     * Add this Object to the user favorites
     */
    public function addFavorite(?int $user_id = null): void
    {
        $favorite = new Favorite(['user_id' => $user_id ?: auth()->id()]);
        $this->favorites()->save($favorite);
    }

    /**
     * Remove this Object from the user favorites
     */
    public function removeFavorite(?int $user_id = null): void
    {
        $this->favorites()->where('user_id', $user_id ?: auth()->id())->delete();
    }

    /**
     * Toggle the favorite status from this Object
     */
    public function toggleFavorite(?int $user_id = null): void
    {
        $this->isFavorited($user_id) ? $this->removeFavorite($user_id) : $this->addFavorite($user_id);
    }

    /**
     * Check if the user has favorited this Object
     */
    public function isFavorited(?int $user_id = null): bool
    {
        return $this->favorites()
            ->where('user_id', $user_id ?: auth()->id())
            ->exists();
    }

    /**
     * Return a collection with the Users who marked as favorite this Object.
     */
    public function favoritedBy(): Collection
    {
        return $this->favorites()
            ->with('user')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item['user']->id => $item['user']];
            });
    }

    /**
     * Count the number of favorites
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }

    public function favoritesCount()
    {
        return $this->favoritesCount;
    }
}
