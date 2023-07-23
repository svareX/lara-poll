<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

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
        Poll::make([
            'title' => $request->title,
            'ends_at' => $request->ends_at,
        ])->user()->associate($request->user())->save();
        return redirect()->route('polls.index')->with('success', 'Poll created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Poll $poll)
    {
        return inertia('Poll/Show', [
            'poll' => $poll->load('options'),
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
