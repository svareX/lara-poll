<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollOptionUser;
use Carbon\Carbon;
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
            'polls' => Poll::where('ends_at', '>', Carbon::now())->latest()->with('options')->with(['options' => function ($query) {
                $query->withCount('users');
            }])->paginate(6),
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
            'poll' => $poll->load('options')->loadCount('options'),
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
        $counter = 1;
        //poll options updated only data
        if ($poll->options()->count() === $request->option_count) {
            foreach ($poll->options as $option) {
                $option->update([
                    'title' => $request->input('option_title' . $counter),
                    'color' => $request->input('option_color' . $counter),
                ]);
                $counter++;
            }
            //poll options updated data and some were deleted
        } elseif ($poll->options()->count() > $request->option_count) {
            $delete_count = $poll->options()->count() - $request->option_count;
            $poll->options()->latest()->take($delete_count)->delete();
            foreach ($poll->options as $option) {
                $option->update([
                    'title' => $request->input('option_title' . $counter),
                    'color' => $request->input('option_color' . $counter),
                ]);
                $counter++;
            }
        }
        //poll options updated data and some were added
        else {
            $add_count = $request->option_count - $poll->options()->count();
            foreach ($poll->options as $option) {
                $option->update([
                    'title' => $request->input('option_title' . $counter),
                    'color' => $request->input('option_color' . $counter),
                ]);
                $counter++;
            }
            for ($i = $counter; $i < ($counter + $add_count); $i++) {
                PollOption::make([
                    'title' => $request->input('option_title' . $i),
                    'color' => $request->input('option_color' . $i),
                ])->poll()->associate($poll->id)->save();
            }
        }

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
