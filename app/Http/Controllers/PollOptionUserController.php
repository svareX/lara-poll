<?php

namespace App\Http\Controllers;

use App\Events\Voted;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollOptionUser;
use App\Notifications\PollFinished;
use Illuminate\Http\Request;

class PollOptionUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Poll $poll, PollOption $pollOption)
    {
        $this->authorize('create', [PollOptionUser::class, $poll]);
        $request->user()->votes()->attach($pollOption, [
            'poll_id' => $poll->id,
        ]);
        event(new Voted($poll, $pollOption));
        //TODO: Maybe add a new event that notifies the creator of the poll if somebody voted in it.
        return redirect()->back()->with('success', 'Vote cast.');
    }
}
