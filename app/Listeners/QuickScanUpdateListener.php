<?php

namespace App\Listeners;

use App\Events\QuickScanUpdate;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class QuickScanUpdateListener
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
    public function handle(QuickScanUpdate $event): void
    {
        $email_on_event = $event->quick_scan->emailOnEventUpdate();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
