<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuickQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\QuickQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'question', 'correct_answer',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function quickScan(): BelongsTo
    {
        return $this->belongsTo(QuickScan::class);
    }

    public function quickAnswers(): HasMany
    {
        return $this->hasMany(QuickAnswer::class);
    }
}
