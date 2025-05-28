<?php

namespace App\Console\Commands;

use App\Models\NotifyEvent as NotifyLastLoginUsers;
use App\Models\User;
use App\Notifications\NotifyLastLoginUsersEvents;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NotifyEvents extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notify:last_login';

    /**
     * The console command description.
     */
    protected $description = 'Send notification email to users who are absent for certain duration of time';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $notify_events = NotifyLastLoginUsers::all();

        foreach ($notify_events as $event) {
            $duration_threshold = Carbon::now()->subDays($event->duration)->toDateString();

            $absent_users = User::whereDate('last_login_at', '=', $duration_threshold)->get();

            Notification::send($absent_users, new NotifyLastLoginUsersEvents($event));
        }
    }
}
