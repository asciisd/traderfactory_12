<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glossary extends Model
{
    /** @use HasFactory<\Database\Factories\GlossaryFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'title_ar', 'slug', 'initials', 'initials_ar', 'body',
        'body_ar', 'topic', 'topic_ar', 'category', 'category_ar'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
