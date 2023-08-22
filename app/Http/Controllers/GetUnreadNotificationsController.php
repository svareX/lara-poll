<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetUnreadNotificationsController extends Controller
{
    public function __invoke()
    {
        return auth()->user()->unreadNotifications()->get();
    }
}
