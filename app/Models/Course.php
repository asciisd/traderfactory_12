<?php

namespace App\Models;

use App\Contracts\OrderableInterface;
use App\Traits\HasOrders;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model implements OrderableInterface
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    use HasOrders;

    protected $fillable = [
        'title', 'title_line_2', 'slug', 'description',
        'video_src', 'video_type', 'video_poster', 'background_src',
        'price', 'tax', 'discount',
        'seo_title', 'meta_title', 'meta_description', 'meta_keywords', 'meta_image',
        'active',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Check if the course is free or paid.
     */
    public function hasPrice(): bool
    {
        return ! empty($this->price);
    }

    public function totalPrice(): float
    {
        return $this->price + $this->tax - $this->discount;
    }

    public function scopeIsPublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now()->format('Y-m-d H:i:s'));
    }

    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('active', 1);
    }

    public function isRelated($model): bool
    {
        return $this->id === $this->section->course->id;
    }

    public function isFree(): bool
    {
        return $this->price <= 0;
    }
}
