<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkNotificationAsReadController extends Controller
{
    public function __invoke()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}
