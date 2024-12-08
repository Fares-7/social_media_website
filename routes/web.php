<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [TweetController::class, 'index'])->name('home');    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::get('/tweets/{tweet}/edit', [TweetController::class, 'edit'])->name('tweets.edit');
    Route::put('/tweets/{tweet}', [TweetController::class, 'update'])->name('tweets.update');
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy'])->name('tweets.destroy');
    Route::post('/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/unlike', [TweetController::class, 'unlike'])->name('tweets.unlike');
    Route::post('/tweets/{tweet}/comment', [TweetController::class, 'comment'])->name('tweets.comment');

    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'destroy'])->name('unfollow');
    
    Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/users/{user}/following', [UserController::class, 'following'])->name('users.following');

});

require __DIR__.'/auth.php';
