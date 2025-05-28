<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class SendBookLink extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $temp_link;

    /**
     * Create a new notification instance.
     */
    public function __construct(Book $book)
    {
        $url = json_decode($book->file_src)->path;
        $this->temp_link = Storage::disk('s3_public')->temporaryUrl($url, now()->addMinutes(5));
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
            ->line('يمكنك تحميل الكتاب من الرابط التالى')
            ->action('رابط التحميل', $this->temp_link);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
