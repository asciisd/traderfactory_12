<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Book;
use App\Models\Order;
use App\Notifications\BookInvoice;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if the status was changed to SUCCESS
        if ($order->isDirty('status') && $order->status === OrderStatus::Success) {
            // If this is a book order, send the invoice
            if ($order->orderable_type === Book::class && $order->orderable) {
                $order->user->notify(new BookInvoice($order->orderable, $order));
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
