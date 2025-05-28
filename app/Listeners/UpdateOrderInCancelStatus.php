<?php

namespace App\Listeners;

use App\Models\Order;
use Asciisd\Kashier\Events\KashierResponseHandled;

class UpdateOrderInCancelStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(KashierResponseHandled $event): void
    {
        logger()->info('KashierResponseHandled', $event->payload);

        // Process all payment responses, not just CANCELLED
        if (isset($event->payload['merchantOrderId'])) {
            $order = Order::where('transaction_id', $event->payload['merchantOrderId'])->first();

            if ($order) {
                $order->update([
                    'status' => $event->payload['paymentStatus'] ?? $order->status,
                    'payment_response' => $event->payload,
                ]);
            }
        }
    }
}
