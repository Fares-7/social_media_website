<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function followers(User $user)
    {
        $followers = $user->followers; // استرجاع المتابعين
        return view('users.followers', compact('followers'));
    }

    public function following(User $user)
    {
        $following = $user->followings; // استرجاع من يتم متابعتهم
        return view('users.following', compact('following'));
    }
}
