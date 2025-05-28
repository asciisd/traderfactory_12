<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevisionItem extends Model
{
    /** @use HasFactory<\Database\Factories\RevisionItemFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function revision(): BelongsTo
    {
        return $this->belongsTo(Revision::class);
    }
}
