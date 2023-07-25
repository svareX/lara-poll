<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollOptionUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Poll/Index', [
            'polls' => Poll::latest()->with('options')->with(['options' => function ($query) {
                $query->withCount('users');
            }])->take(10)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Poll/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Poll::make([
                'title' => $request->title,
                'ends_at' => $request->ends_at,
            ])->user()->associate($request->user())->save();
            $poll_id = Poll::latest()->first()->id;
            for ($i = 1; $i <= $request->option_count; $i++) {
                PollOption::make([
                    'title' => $request->input('option_title' . $i),
                    'color' => $request->input('option_color' . $i),
                ])->poll()->associate($poll_id)->save();
            }
            return redirect()->route('polls.index')->with('success', 'Poll created.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('polls.index')->with('error', 'Poll not created.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        return inertia('Poll/Show', [
            'poll' => $poll->load('options')->load('options.users')->load(['options' => function ($query) {
                $query->withCount('users');
            }]),
            'history' => PollOptionUser::where('poll_id', $poll->id)->with('user')->with('option')->orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poll $poll)
    {
        return inertia('Poll/Edit', [
            'poll' => $poll->load('options'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poll $poll)
    {
        $poll->update([
            'title' => $request->title,
            'ends_at' => $request->ends_at,
        ]);
        return redirect()->route('polls.index')->with('success', 'Poll updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return redirect()->route('polls.index')->with('success', 'Poll deleted.');
    }
}
