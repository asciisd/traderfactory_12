<?php

namespace App\Listeners;

use App\Models\Order;
use Asciisd\Kashier\Events\KashierResponseHandled;

class UpdateOrderAfterKashierResponse
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

        // Process all payment responses
        if (isset($event->payload['merchantOrderId'])) {
            $order = Order::where('transaction_id', $event->payload['merchantOrderId'])->first();

            if ($order) {
                // Get the payment status from the payload
                $paymentStatus = $event->payload['paymentStatus'] ?? null;

                // Update the order with the new status if available
                if ($paymentStatus) {
                    $order->update([
                        'status' => $paymentStatus,
                        'payment_response' => $event->payload,
                    ]);
                }

                logger()->info('KashierResponseHandled: Order updated successfully', [
                    'order_id' => $order->id,
                    'status' => $paymentStatus ?? 'unchanged',
                ]);

                // If this is a successful book purchase, prepare for redirect
                // The email will be sent by the OrderObserver when the status changes to SUCCESS
                if ($paymentStatus === 'SUCCESS' && $order->orderable_type === 'App\Models\Book') {
                    // Store book_id in session for redirect after payment
                    session(['successful_book_purchase' => true, 'book_id' => $order->orderable_id]);
                }
            } else {
                logger()->error('KashierResponseHandled: Order not found', [
                    'merchantOrderId' => $event->payload['merchantOrderId'],
                ]);
            }
        } else {
            logger()->error('KashierResponseHandled: Invalid payload structure', $event->payload);
        }
    }
}
