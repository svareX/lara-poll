<?php

namespace App\Listeners;

use App\Models\Poll;
use App\Notifications\PollFinished;
use App\Notifications\PollLost;
use App\Notifications\PollWon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyUsersAfterPollEnded
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
    public function handle(object $event): void
    {
        //poll creator
        $event->poll->user->notify(new PollFinished($event->poll));
        $options = $event->poll->options()->with('users')->withCount('users')->orderBy('users_count', 'desc')->get();
        for ($i = 0; $i < count($options); $i++) {
            //TODO: Check if more than 1 poll has the most votes (draw)
            //won
            if ($i === 0) {
                foreach ($options[$i]->users as $user) {
                    $user->notify(new PollWon($event->poll));
                }
            }
            //lost
            else {
                foreach ($options[$i]->users as $user) {
                    $user->notify(new PollLost($event->poll));
                }
            }
        }
    }
}
