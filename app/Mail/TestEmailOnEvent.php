<?php

namespace App\Mail;

use App\Models\EmailOnEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmailOnEvent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $htmlString;

    /**
     * Create a new message instance.
     */
    public function __construct(public EmailOnEvent $emailOnEvent)
    {
        $usrArr = [
            'name' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+00000000000',
            'country' => 'United States',
        ];

        $tmpKeys = [];
        $tmpValues = array_values($usrArr);

        // Replace all placeholders in HTML with the actual values
        foreach (array_keys($usrArr) as $key) {
            $tmpKeys[] = '{{ '.$key.' }}';
        }

        $this->htmlString = str_replace($tmpKeys, $tmpValues, $this->emailOnEvent->html);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailOnEvent->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: $this->htmlString,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
