<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Profile/Poll/Index')->with([
            'polls' => auth()->user()->polls()->with('options')->with(['options' => function ($query) {
                $query->withCount('users');
            }])->latest()->paginate(6),
        ]);
    }
}
