<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function show(User $user)
{
    $followersCount = $user->followers()->count();
    $followingCount = $user->following()->count();
    $tweetCount = $user->tweets()->count(); // Change postCount to tweetCount
    $tweets = $user->tweets()->latest()->paginate(10);

    return view('users.show', compact('user', 'followersCount', 'followingCount', 'tweetCount', 'tweets'));
}}
