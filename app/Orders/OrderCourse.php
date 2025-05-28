<?php

namespace App\Orders;

use App\Contracts\MakeOrder;
use App\Contracts\Repositories\PaymentGateway;
use App\Models\Course;
use App\Models\Order;
use App\PaymentGateways\KashierPaymentGateway;

class OrderCourse implements MakeOrder
{
    /**
     * Holds course model.
     */
    public Course $course;

    /**
     * Holds payment gateway object.
     */
    public PaymentGateway $paymentGateway;

    public function __construct($course_id)
    {
        $this->course = Course::findOrFail($course_id);
    }

    public function paidOrder(): void
    {
        // Making payment.
        $this->paymentGateway = KashierPaymentGateway::pay($this->course->price, "Buy Course");

        // Create the order
        Order::create($this->preparePaidOrder($this->paymentGateway));
    }

    public function freeOrder(): void
    {
        Order::create([
            'status' => 'SUCCESS',
            'provider' => 'OFFLINE',
            'user_id' => auth()->id(),
            'orderable_type' => Course::class,
            'orderable_id' => $this->course->id,
        ]);
    }

    public function hasPrice(): bool
    {
        return $this->course->hasPrice();
    }

    public function ownedByUser(): bool
    {
        return $this->course->purchased();
    }

    public function preparePaidOrder($paymentGateway = null): array
    {
        // Create order.
        return [
            'orderable_type' => Course::class,
            'orderable_id' => $this->course->id,
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
