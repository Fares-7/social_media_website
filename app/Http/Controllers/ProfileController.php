<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Update name
    $user->name = $request->name;

    // Handle photo upload
    if ($request->hasFile('profile_photo')) {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $path = $request->file('profile_photo')->store('profile-images', 'public');
        $user->image = $path;
    }

    $user->save();

    // Change redirect to home page
    return Redirect::route('home')->with('status', 'Profile updated successfully!');
}


public function destroy(Request $request): RedirectResponse
{
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();
    Auth::logout();
    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::route('home');
}

}
