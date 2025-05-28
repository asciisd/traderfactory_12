<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderObserver;
use App\Traits\HasCurrentUserScope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use HasCurrentUserScope;

    protected $fillable = [
        'user_id', 'course_id', 'transaction_id', 'status', 'conversion_rate', 'vendor_fees', 'currency', 'method',
        'provider', 'total', 'sub_total', 'orderable_type', 'orderable_id', 'payment_response'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => OrderStatus::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
