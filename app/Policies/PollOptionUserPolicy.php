<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\PollOptionUser;
use App\Models\User;

class PollOptionUserPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Poll $poll): bool
    {
        if ($poll->user_id === $user->id) {
            return false;
        }

        if (PollOptionUser::where('user_id', $user->id)->where('poll_id', $poll->id)->first()) {
            return false;
        } else {
            return true;
        }
    }
}
