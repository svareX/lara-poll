<?php

namespace App\Events;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Voted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Poll $poll;
    public PollOption $option;
    /**
     * Create a new event instance.
     */
    public function __construct(Poll $poll, PollOption $option)
    {
        $this->poll = $poll;
        $this->option = $option;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('poll.' . $this->poll->id),
        ];
    }
}
