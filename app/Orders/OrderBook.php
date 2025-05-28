<?php

namespace App\Orders;

use App\Contracts\MakeOrder;
use App\Contracts\Repositories\PaymentGateway;
use App\Models\Book;
use App\Models\Order;
use App\Notifications\BookInvoice;
use App\PaymentGateways\KashierPaymentGateway;

class OrderBook implements MakeOrder
{
    /**
     * Holds book model.
     */
    public Book $book;

    /**
     * Holds payment gateway object.
     */
    public PaymentGateway $paymentGateway;

    public function __construct($book_id)
    {
        $this->book = Book::findOrFail($book_id);
    }

    public function paidOrder()
    {
        if ($this->ownedByUser()) {
            return back()->with(['message' => 'أنت بالفعل مشترك فى هذه الدورة التدريبية!']);
        }

        // Making payment.
        $this->paymentGateway = KashierPaymentGateway::pay($this->book->totalPrice(), "Buy Book");

        // Create the order
        $order = Order::create($this->preparePaidOrder($this->paymentGateway));

        // We don't send the invoice email here because the payment is not yet confirmed
        // The invoice will be sent after a successful payment callback
    }

    public function freeOrder(): void
    {
        $order = Order::create([
            'status' => 'SUCCESS',
            'provider' => 'OFFLINE',
            'user_id' => auth()->id(),
            'orderable_type' => 'App\Models\Book',
            'orderable_id' => $this->book->id,
        ]);

        // For free books, send an invoice immediately
        if ($order) {
            auth()->user()->notify(new BookInvoice($this->book, $order));
        }
    }

    public function hasPrice(): bool
    {
        return ! empty($this->book->price);
    }

    public function ownedByUser(): bool
    {
        return $this->book->purchased();
    }

    public function preparePaidOrder($paymentGateway = null): array
    {
        // Create order.
        return [
            'orderable_type' => 'App\Models\Book',
            'orderable_id' => $this->book->id,
            'transaction_id' => $paymentGateway->id(),
            'status' => $paymentGateway->status(),
            'user_id' => $paymentGateway->owner()->id,
            'currency' => $paymentGateway->currency(),
            'method' => $paymentGateway->paymentMethod(),
            'provider' => $paymentGateway->provider(),
            'conversion_rate' => $paymentGateway->conversionRate(),
            'vendor_fees' => $paymentGateway->vendorFees(),
            'sub_total' => $paymentGateway->rawAmount(),
            'total' => $paymentGateway->calculateTotalAmount(),
        ];
    }
}
