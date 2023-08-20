<?php

namespace App\Listeners;

use App\Models\Poll;
use App\Notifications\PollFinished;
use App\Notifications\PollLost;
use App\Notifications\PollWon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PollEnded
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
        $event->poll->user->notify(new PollFinished($event->poll));
        foreach ($event->poll->options->users as $user) {
            $options = Poll::find($event->poll->id)->options()->withCount('users')->orderBy('users_count', 'desc')->get();
            for ($i = 0; $i < count($options); $i++) {
                //TODO: Check if more than 1 option has the most votes (draw)
                if ($i === 0) {
                    $user->notify(new PollWon($event->poll));
                } else {
                    $user->notify(new PollLost($event->poll));
                }
            }
        }
    }
}
