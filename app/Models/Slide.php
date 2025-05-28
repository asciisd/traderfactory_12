<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slide extends Model
{
    /** @use HasFactory<\Database\Factories\SlideFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'background_url', 'layout',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class);
    }

    public function slideItems(): HasMany
    {
        return $this->hasMany(SlideItem::class);
    }
}
