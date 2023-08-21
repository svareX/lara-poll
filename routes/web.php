<?php

use App\Http\Controllers\MarkNotificationAsReadController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PollOptionUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPollController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/polls/{poll}/poll-option/{pollOption}', [PollOptionUserController::class, 'store'])->name('polls.vote');
    Route::resource('/polls', PollController::class);
    Route::resource('/users.polls', UserPollController::class)->only(['index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications', MarkNotificationAsReadController::class)->name('notifications.markAsRead');
});

require __DIR__ . '/auth.php';
