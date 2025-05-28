<?php

namespace App\Listeners;

use App\Models\Order;
use Asciisd\Kashier\Events\KashierWebhookHandled;

class UpdateOrderAfterKashierCharge
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
    public function handle(KashierWebhookHandled $event): void
    {
        logger()->info('KashierWebhookHandled', $event->payload);

        if (! isset($event->payload['data']) || ! isset($event->payload['data']['merchantOrderId'])) {
            logger()->error('KashierWebhookHandled: Invalid payload structure', $event->payload);

            return;
        }

        $data = $event->payload['data'];
        $merchantOrderId = $data['merchantOrderId'];

        $order = Order::where('transaction_id', $merchantOrderId)->first();

        if (! $order) {
            logger()->error('KashierWebhookHandled: Order not found', ['merchantOrderId' => $merchantOrderId]);

            return;
        }

        $order->update([
            'status' => $data['status'],
            'payment_response' => $event->payload,
        ]);

        logger()->info('KashierWebhookHandled: Order updated successfully', [
            'order_id' => $order->id,
            'status' => $data['status'],
        ]);
    }
}
