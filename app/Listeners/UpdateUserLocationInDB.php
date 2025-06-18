<?php

namespace App\Listeners;

use App\Events\UsersEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\EventUser;
use App\Models\User;

class UpdateUserLocationInDB
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
    public function handle(UsersEvent $event): void
    {
        $user = User::where('id', $event->user_id)
        ->first();
        $user->event_user()->detach($event->event_id);
        if ($event->user_stauts) {
            $user->event_user()->attach($event->event_id);
        }
    }
}
