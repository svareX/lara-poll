<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\PollOptionUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return inertia('Poll/Index');
});

Route::resource('poll', PollController::class);
Route::post('poll/{poll}/poll-option/{pollOption}', [PollOptionUserController::class, 'store'])->name('poll.vote');
