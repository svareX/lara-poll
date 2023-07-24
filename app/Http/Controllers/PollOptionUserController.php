<?php

namespace App\Http\Controllers;

use App\Events\Voted;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Http\Request;

class PollOptionUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Poll $poll, PollOption $pollOption)
    {
        $request->user()->votes()->attach($pollOption, [
            'poll_id' => $poll->id,
        ]);
        Voted::dispatch($poll->options()->withCount('users')->get()->toArray());
        return redirect()->route('polls.index')->with('success', 'Vote cast.');
    }
}
