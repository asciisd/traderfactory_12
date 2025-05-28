<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Favorability
{
    /**
     * Define a one-to-many relationship.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Return a collection with the User favorited Model.
     * The Model needs to have the Favoriteable trait
     *
     * @param  $class *** Accepts, for example, Post::class or 'App\Post' ****
     */
    public function favorite($class
    ): \Illuminate\Database\Eloquent\Collection
    {
        return $this->favorites()
            ->where('favorable_type', $class)
            ->with('favorable')
            ->get()
            ->mapWithKeys(function ($item) {
                if (isset($item['favorable'])) {
                    return [$item['favorable']->id => $item['favorable']];
                }

                return [];
            });
    }

    /**
     * Add the object to the User favorites.
     * The Model needs to have the Favoriteable trait
     *
     * @param object $object
     */
    public function addFavorite($object)
    {
        $object->addFavorite($this->id);
    }

    /**
     * Remove the Object from the user favorites.
     * The Model needs to have the Favoriteable trait
     *
     * @param object $object
     */
    public function removeFavorite($object)
    {
        $object->removeFavorite($this->id);
    }

    /**
     * Toggle the favorite status from this Object from the user favorites.
     * The Model needs to have the Favoriteable trai
     *
     * @param object $object
     */
    public function toggleFavorite($object)
    {
        $object->toggleFavorite($this->id);
    }

    /**
     * Check if the user has favorited this Object
     * The Model needs to have the Favoriteable trai
     *
     * @param object $object
     */
    public function isFavorited($object): bool
    {
        return $object->isFavorited($this->id);
    }

    /**
     * Check if the user has favorited this Object
     * The Model needs to have the Favoriteable trai
     *
     * @param object $object
     */
    public function hasFavorited($object): bool
    {
        return $object->isFavorited($this->id);
    }
}
