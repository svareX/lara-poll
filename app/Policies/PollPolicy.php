<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PollPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->is_admin) {
            return true;
        } else {
            return null;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Poll $poll): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Poll $poll): bool
    {
        return $user->id === $poll->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Poll $poll): bool
    {
        return $user->id === $poll->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Poll $poll): bool
    {
        return $user->id === $poll->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Poll $poll): bool
    {
        return $user->id === $poll->user_id;
    }
}
