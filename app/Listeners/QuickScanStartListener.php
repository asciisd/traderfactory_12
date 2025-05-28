<?php

namespace App\Listeners;

use App\Events\QuickScanStart;
use App\Mail\EmailOnEventMail;
use Illuminate\Support\Facades\Mail;

class QuickScanStartListener
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
    public function handle(QuickScanStart $event): void
    {
        $email_on_event = $event->quick_scan->emailOnEventStart();

        if ($email_on_event) {
            Mail::to($event->user)->send(new EmailOnEventMail($email_on_event, $event->user));
        }
    }
}
