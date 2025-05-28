<?php

namespace App\Notifications;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookInvoice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Book $book, protected Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('فاتورة شراء كتاب: '.$this->book->name)
            ->markdown('mail.book-invoice', [
                'user' => $notifiable,
                'book' => $this->book,
                'order' => [
                    'id' => $this->order->id,
                    'amount' => $this->order->total,
                    'paymentStatus' => $this->order->status,
                    'orderReference' => $this->order->transaction_id,
                    'transactionId' => $this->order->transaction_id,
                    'cardBrand' => $this->order->method,
                    'currency' => $this->order->currency,
                    'created_at' => $this->order->created_at,
                    'serviceType' => 'Buy Book',
                ],
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'book_id' => $this->book->id,
            'book_name' => $this->book->name,
            'order_id' => $this->order->id,
            'order_total' => $this->order->total,
        ];
    }
}
