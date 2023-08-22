<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetReadNotificationsController extends Controller
{
    public function __invoke()
    {
        return auth()->user()->readNotifications()->get();
    }
}
