<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyEvent extends Model
{
    /** @use HasFactory<\Database\Factories\NotifyEventFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'duration', 'message'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
