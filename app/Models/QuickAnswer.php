<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\QuickAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'choice', 'description',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function quickQuestion(): BelongsTo
    {
        return $this->belongsTo(QuickQuestion::class);
    }
}
