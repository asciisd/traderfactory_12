<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    /** @use HasFactory<\Database\Factories\MetaDataFactory> */
    use HasFactory;

    protected $fillable = [
        'page_slug', 'title', 'image', 'description', 'keywords'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
