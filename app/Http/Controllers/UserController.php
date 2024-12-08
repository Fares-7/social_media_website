<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function show(User $user)
{
    $tweets = $user->tweets()->latest()->paginate(10);
    $followersCount = $user->followers()->count();
    $followingCount = $user->following()->count();
    $postCount = $user->tweets()->count();

    return view('users.show', compact('user', 'tweets', 'followersCount', 'followingCount', 'postCount'));

}
}
