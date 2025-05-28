<?php

namespace App\Models;

use App\Contracts\OrderableInterface;
use App\Traits\HasOrders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model implements OrderableInterface
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    use HasOrders;

    protected $fillable = [
        'name', 'description', 'image_src', 'image_alt',
        'file_src', 'file_cta', 'price', 'tax', 'discount'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'float',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function totalPrice(): float
    {
        return $this->price + $this->tax - $this->discount;
    }
}
