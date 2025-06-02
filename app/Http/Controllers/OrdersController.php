<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
use App\Orders\OrderBook;
use App\Orders\OrderCourse;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public OrderCourse|OrderBook $model;

    public function order(OrderCreateRequest $request, string $type, $id)
    {
        $this->model = match ($type) {
            'course' => new OrderCourse($id),
            'book' => new OrderBook($id)
        };

        if ($this->model->ownedByUser()) {
            session()->flash('success', 'أنت بالفعل مشترك فى هذا العنصر!');
            return back();
        }

        // If order has price.
        if ($this->model->hasPrice()) {
            $this->model->paidOrder();

            if ($type === 'book') {
                // For books, capture the payment gateway URL
                $paymentUrl = $this->model->paymentGateway->actionUrl();

                // Store the URL in session to redirect after payment
                session(['book_payment_url' => $paymentUrl, 'book_id' => $id]);

                return Inertia::location($paymentUrl);
            }

            return Inertia::location($this->model->paymentGateway->actionUrl());

        } else {
            // Register to free course/book.
            $this->model->freeOrder();
            session()->flash('success', 'تم الإشتراك بنجاح');

            if ($type === 'book') {
                // For free books, redirect to the download page
                return redirect()->route('books.download.page', ['book' => $id]);
            }

            return back();
        }
    }

    public function receipt(Order $order)
    {
        return view('mail.order-receipt', [
            'order' => [
                'id' => $order->id,
                'amount' => $order->total,
                'paymentStatus' => $order->status,
                'orderReference' => $order->transaction_id,
                'transactionId' => $order->transaction_id,
                'cardBrand' => $order->method,
                'currency' => $order->currency,
                'created_at' => $order->created_at,
            ],
        ]);
    }
}
